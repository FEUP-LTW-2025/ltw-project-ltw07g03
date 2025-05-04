<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/services_history.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/complex_queries.php');

$session = new Session();
$db = getDatabaseConnection();
$freelancerId = isset($_GET['freelancerId']) ? intval($_GET['freelancerId']) : 0;
$purchases = getPurchasesByFreelancerId($db, $freelancerId);

drawHeader("History", $db, $session);
drawServicesHistory($db, $purchases);
drawFooter();