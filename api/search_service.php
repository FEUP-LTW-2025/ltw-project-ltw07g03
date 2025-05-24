<?php
declare(strict_types=1);
require_once(__DIR__ . "/../model/service.class.php");
require_once(__DIR__ . "/../database/connection.db.php");
require_once(__DIR__ . "/../utils/security.php");

header('Content-Type: application/json');

$db = getDatabaseConnection();

$search = Security::sanitizeInput($_GET['search'] ?? '');
$category = isset($_GET['category']) ? intval($_GET['category']) : null;
$budget = isset($_GET['budget']) ? intval($_GET['budget']) : null;
$rating = isset($_GET['rating']) ? intval($_GET['rating']) : null;

if ($category !== null && $category < 0) $category = null;
if ($budget !== null && $budget < 0) $budget = null;
if ($rating !== null && ($rating < 1 || $rating > 5)) $rating = null;

if (strlen($search) > 100) {
    http_response_code(400);
    echo json_encode(['error' => 'Search query too long']);
    exit;
}

try {
    $services = Service::getServicesBySearch($db, $search, 50, $category, $budget, $rating);
    echo json_encode($services);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
