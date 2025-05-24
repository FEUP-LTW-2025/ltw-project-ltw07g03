<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../utils/image_upload.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/service.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to create a service.');
    header('Location: /pages/login.php');
    exit();
}

if (!Security::validateCSRFToken($session)) {
    $session->addMessage('error', 'Invalid request. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$db = getDatabaseConnection();

$uploadDir = __DIR__ . '/../assets/images/services/';
$uploadUrl = '/assets/images/services/';
$defaultServicePicture = $uploadUrl . 'default.jpeg';

$freelancerId = intval($_POST['userId']);
$categoryId = intval($_POST['categoryId']);
$title = Security::sanitizeInput($_POST['title'] ?? '');
$price = floatval($_POST['price']);
$deliveryTime = intval($_POST['deliveryTime']);
$description = Security::sanitizeInput($_POST['description'] ?? '');
$about = Security::sanitizeInput($_POST['about'] ?? '');
$status = $_POST['status'] ?? '';

if ($freelancerId !== $session->getId()) {
    $session->addMessage('error', 'You can only create services for yourself.');
    header('Location: /pages/index.php');
    exit();
}

if (
    empty($title) || empty($description) || empty($about) ||
    $price <= 0 || $deliveryTime <= 0 || $categoryId <= 0 ||
    !in_array($status, ['active', 'inactive'])
) {
    $session->addMessage('error', 'All fields are required and must be valid.');
    header('Location: /pages/service_creation.php');
    exit();
}

$mockId = 0;
$mockRating = 0.0;

$mediaURLs = [];
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxFileSize = 5 * 1024 * 1024;

if (!empty($_FILES['images']['tmp_name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
            $fileArray = [
                'name' => $_FILES['images']['name'][$index],
                'type' => $_FILES['images']['type'][$index],
                'tmp_name' => $_FILES['images']['tmp_name'][$index],
                'error' => $_FILES['images']['error'][$index],
                'size' => $_FILES['images']['size'][$index]
            ];

            if (!Security::validateFileUpload($fileArray, $allowedTypes, $maxFileSize)) {
                $session->addMessage('error', 'Invalid file upload. Only images under 5MB are allowed.');
                header('Location: /pages/service_creation.php');
                exit();
            }

            $mediaURL = handleSingleImageUpload($fileArray, $uploadDir, $uploadUrl, $defaultServicePicture, $session);
            if ($mediaURL) {
                $mediaURLs[] = $mediaURL;
            }
        }
    }
} else {
    $mediaURLs[] = $defaultServicePicture;
}

$newService = new Service($mockId, $freelancerId, $categoryId, $title, $price, $deliveryTime, $description, $about, $status, $mockRating, $mediaURLs);
$newService->upload($db);

$session->addMessage('success', 'Service created successfully');
header('Location: /pages/user.php?id=' . $freelancerId);
exit();
