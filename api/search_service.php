<?php
declare(strict_types=1);

require_once(__DIR__ . "/../model/service.class.php");
require_once(__DIR__ . "/../database/connection.db.php");

$db = getDatabaseConnection();
$services = Service::getServicesBySearch($db, $_GET["search"], 50);

echo json_encode($services);
