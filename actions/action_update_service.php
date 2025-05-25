<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/service.class.php');

header('Content-Type: application/json');

$session = new Session();

if (!$session->isLoggedIn()) {
    echo json_encode(['error' => 'You must be logged in to update services']);
    http_response_code(401);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$db = getDatabaseConnection();

if (!$input) {
    echo json_encode(['error' => 'Invalid data provided']);
    http_response_code(400);
    exit;
}

$serviceId = intval($input['serviceId']) ?? null;
$title = $input['title'] ?? null;
$price = intval($input['price']) ?? null;
$description = $input['description'] ?? null;
$about = $input['about'] ?? null;
$deliveryTime = intval($input['deliveryTime']) ?? null;


if (!$serviceId || !$title || !is_numeric($price) || !$description || !$about || !is_numeric($deliveryTime)) {
    echo json_encode(['error' => 'Missing or invalid fields']);
    http_response_code(422);
    exit;
}

$service = Service::getServiceById($db, $serviceId);

if (!$service) {
    echo json_encode(['error' => 'Service not found']);
    http_response_code(404);
    exit;
}

if ($service->getFreelancerId() !== $session->getId()) {
    echo json_encode(['error' => 'You can only update your own services']);
    http_response_code(403);
    exit;
}

$service->updateService($db, $title, $price, $deliveryTime, $description, $about);

echo json_encode(['success' => true, 'message' => 'Service updated successfully']);
