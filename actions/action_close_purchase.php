<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/purchase.class.php');
require_once(__DIR__ . '/../model/service.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in.');
    header('Location: /pages/login.php');
    exit();
}

if (!Security::validateCSRFToken($session)) {
    $session->addMessage('error', 'Invalid request. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$db = getDatabaseConnection();

$purchaseId = intval($_POST["purchaseId"] ?? 0);
$freelancerId = intval($_POST["freelancerId"] ?? 0);

if ($purchaseId <= 0 || $freelancerId <= 0) {
    $session->addMessage('error', 'Invalid purchase or freelancer ID.');
    header('Location: /pages/index.php');
    exit();
}

$purchase = Purchase::getPurchaseById($db, $purchaseId);
if (!$purchase) {
    $session->addMessage('error', 'Purchase not found.');
    header('Location: /pages/index.php');
    exit();
}

$service = Service::getServiceById($db, $purchase->getServiceId());
if (!$service || $service->getFreelancerId() !== $session->getId()) {
    $session->addMessage('error', 'You can only close purchases for your own services.');
    header('Location: /pages/index.php');
    exit();
}

if ($purchase->getStatus() === 'closed') {
    $session->addMessage('info', 'Purchase is already closed.');
} else {
    $purchase->setStatus("closed", $db);
    $session->addMessage('success', 'Purchase closed successfully.');
}

header("Location: /pages/services_history.php?id=$freelancerId");
exit();
