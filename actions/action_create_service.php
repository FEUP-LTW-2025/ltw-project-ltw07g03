<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/image_upload.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/service.class.php');

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
$status = $_POST['status'];

$mockId = 0;
$mockRating = 0.0;
$mediaURL = handleImageUpload('image', $uploadDir, $uploadUrl, $defaultServicePicture, $session);


$newService = new Service($mockId, $freelancerId, $categoryId, $title, $price, $deliveryTime, $description, $status, $mockRating, array($mediaURL));
$newService->upload($db);

$session->addMessage('success', 'Service created successfully');
header('Location: /pages/user.php?id=' . $freelancerId);
