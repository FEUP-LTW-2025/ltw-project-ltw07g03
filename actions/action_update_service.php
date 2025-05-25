<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/service.class.php');

header('Content-Type: application/json');


$input = json_decode(file_get_contents('php://input'), true);
$db = getDatabaseConnection();

if (!$input) {
    echo json_encode(['error' => 'Dados inválidos']);
    http_response_code(400);
    exit;
}

// Exemplo de acesso aos dados
$serviceId = intval($input['serviceId']) ?? null;
$title = $input['title'] ?? null;
$price = intval($input['price']) ?? null;
$description = $input['description'] ?? null;
$about = $input['about'] ?? null;
$deliveryTime = intval($input['deliveryTime']) ?? null;


if (!$serviceId || !$title || !is_numeric($price) || !$description || !$about || !is_numeric($deliveryTime)) {
    echo json_encode(['error' => 'Campos em falta ou inválidos']);
    http_response_code(422);
    exit;
}

$service = Service::getServiceById($db, $serviceId);
$service->updateService($db, $title, $price, $deliveryTime, $description, $about);

echo json_encode(['success' => true]);
