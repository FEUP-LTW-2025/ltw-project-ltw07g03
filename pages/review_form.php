<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/review_form.tpl.php');
require_once(__DIR__ . '/../model/purchase.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to submit reviews.');
    header('Location: /pages/login.php');
    exit();
}

$db = getDatabaseConnection();

$purchase_id = intval($_GET['purchase_id'] ?? 0);

if ($purchase_id <= 0) {
    $session->addMessage('error', 'Invalid purchase ID.');
    header('Location: /pages/index.php');
    exit();
}

$purchase = Purchase::getPurchaseById($db, $purchase_id);
if (!$purchase || $purchase->getClientId() !== $session->getId()) {
    $session->addMessage('error', 'You can only review your own purchases.');
    header('Location: /pages/index.php');
    exit();
}

drawHeader('Review Form', $db, $session);
drawReviewForm($purchase_id, $session);
drawFooter();
