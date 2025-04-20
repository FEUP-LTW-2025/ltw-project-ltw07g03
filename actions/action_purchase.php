<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/purchase.class.php');

$session = new Session();
$db = getDatabaseConnection();

$serviceId = isset($_GET['serviceId']) ? intval($_GET['serviceId']) : 0;
$clientId = $session->getId();

if ($serviceId === 0 || !$clientId) {
    $session->addMessage('error', 'Invalid request');
    header('Location: /pages/index.php');
    exit();
}

$purchase = new Purchase(0, $serviceId, $clientId, time(), 'pending');
$purchase->upload($db);

$session->addMessage('sucess', 'Purchase successful!');
header('Location: /pages/user.php?id=' . $clientId);
exit();