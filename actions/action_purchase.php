<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/purchase.class.php');
require_once(__DIR__ . '/../model/service.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to make a purchase.');
    header('Location: /pages/login.php');
    exit();
}

if (!Security::validateCSRFToken($session)) {
    $session->addMessage('error', 'Invalid request. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$db = getDatabaseConnection();

$cardNumber = Security::sanitizeInput($_POST['card_number']);
$exp_date = Security::sanitizeInput($_POST['exp_date']);
$sec_code = intval($_POST['sec_code']);
$cardholder_name = Security::sanitizeInput($_POST['cardholder_name']);

if (isset($_POST['serviceId']) && isset($_POST['clientId'])) {
    $serviceId = intval($_POST['serviceId']);
    $clientId = intval($_POST['clientId']);

    if ($clientId !== $session->getId()) {
        $session->addMessage('error', 'You can only make purchases for yourself.');
        header('Location: /pages/index.php');
        exit();
    }

    $service = Service::getServiceById($db, $serviceId);
    if (!$service || $service->getStatus() !== 'active') {
        $session->addMessage('error', 'Service not available.');
        header('Location: /pages/services.php');
        exit();
    }

    if ($service->getFreelancerId() === $clientId) {
        $session->addMessage('error', 'You cannot purchase your own service.');
        header('Location: /pages/services.php');
        exit();
    }
} else {
    $session->addMessage('error', 'Missing parameters');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$mockId = 0;
$status = 'pending';
$date = time();

$purchase = new Purchase($mockId, $serviceId, $clientId, $date, $status);

$purchase_info = [
    'cardNumber' => $cardNumber,
    'exp_date' => $exp_date,
    'sec_code' => $sec_code,
    'cardName' => $cardholder_name
];

$purchase->upload($db, $purchase_info);

$session->addMessage('success', 'Purchase successful!');
header('Location: /pages/services.php');
exit();
