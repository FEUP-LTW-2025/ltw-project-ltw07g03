<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../model/purchase.class.php';

$session = new Session();
$db = getDatabaseConnection();

$purchaseId = intval($_POST["purchaseId"]);
$freelancerId = intval($_POST["freelancerId"]);
$purchase = Purchase::getPurchaseById($db, $purchaseId);
$purchase->setStatus("closed", $db);

header("Location: /pages/services_history.php?id= " . $freelancerId);
exit();
