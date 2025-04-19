<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/service.class.php');

$session = new Session();

$uploadDir = __DIR__ . '/../assets/images/services/';
$uploadUrl = '/assets/images/services/';
$defaultServicePicture = $uploadUrl . 'default.jpeg';

$db = getDatabaseConnection();

$freelancerId = (int)$_POST['userId'];
$categoryId = (int)$_POST['categoryId'];

$title = htmlspecialchars(trim($_POST['title']));
$price = (float)$_POST['price'];
$deliveryTime = (int)$_POST['deliveryTime'];
$description = htmlspecialchars(trim($_POST['description']));

$status = $_POST['status'];

function handlePicture(string $uploadDir, string $uploadUrl, string $default, Session $session): string
{
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return $default;
    }

    $file = $_FILES['image'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        $session->addMessage('error', 'Profile picture type not allowed. Allowed: .jpeg, .png, .gif');
        return $default;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid('service_', true) . '.' . $ext;

    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $uploadUrl . $filename;
    } else {
        $session->addMessage('error', 'Failed to upload image. Default picture used.');
        return $default;
    }
}


$mockId = 0;
$mockRating = 0.0;
$mediaURL = handlePicture($uploadDir, $uploadUrl, $defaultServicePicture, $session);


$newService = new Service($mockId, $freelancerId, $categoryId, $title, $price, $deliveryTime, $description, $status, $mockRating, array($mediaURL));
$newService->upload($db);

$session->addMessage('success', 'Service created successfully');
header('Location: /pages/user.php?id=' . $freelancerId);
