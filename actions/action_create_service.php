<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/image_upload.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/service.class.php');
//echo '<pre>';
//var_dump($_FILES);
//echo '</pre>';
//exit;

$session = new Session();
$db = getDatabaseConnection();

$uploadDir = __DIR__ . '/../assets/images/services/';
$uploadUrl = '/assets/images/services/';
$defaultServicePicture = $uploadUrl . 'default.jpeg';

$freelancerId = intval($_POST['userId']);
$categoryId = intval($_POST['categoryId']);
$title = htmlspecialchars(trim($_POST['title']));
$price = floatval($_POST['price']);
$deliveryTime = intval($_POST['deliveryTime']);
$description = htmlspecialchars(trim($_POST['description']));
$about = htmlspecialchars(trim($_POST['about']));  
$status = $_POST['status'];

$mockId = 0;
$mockRating = 0.0;
//$mediaURL = handleImageUpload('image', $uploadDir, $uploadUrl, $defaultServicePicture, $session);


///
$mediaURLs = [];

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

            $mediaURL = handleSingleImageUpload($fileArray, $uploadDir, $uploadUrl, $defaultServicePicture, $session);
            $mediaURLs[] = $mediaURL;
        }
    }
}




///
$newService = new Service($mockId, $freelancerId, $categoryId, $title, $price, $deliveryTime, $description, $about, $status, $mockRating, $mediaURLs);
$newService->upload($db);

$session->addMessage('success', 'Service created successfully');
header('Location: /pages/user.php?id=' . $freelancerId);
