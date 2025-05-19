<?php
declare(strict_types=1);
require_once(__DIR__ . "/../model/service.class.php");
require_once(__DIR__ . "/../database/connection.db.php");

$db = getDatabaseConnection();

$search   = $_GET['search']   ?? '';
$category = isset($_GET['category']) ? (int)$_GET['category'] : null;
$budget = isset($_GET['budget']) ? (int)$_GET['budget'] : null;
$services = Service::getServicesBySearch($db, $search, 50, $category, $budget);

header('Content-Type: application/json');
echo json_encode($services);
