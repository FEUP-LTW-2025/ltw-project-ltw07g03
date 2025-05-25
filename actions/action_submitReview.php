<?php

declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/feedback.class.php');
require_once(__DIR__ . '/../model/purchase.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to submit reviews.');
    header('Location: /pages/login.php');
    exit();
}

if (!Security::validateCSRFToken($session)) {
    $session->addMessage('error', 'Invalid request. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$db = getDatabaseConnection();

$purchase_id = intval($_POST['purchase_id'] ?? 0);
$feedback_text = Security::sanitizeInput($_POST['feedback'] ?? '');
$rating = intval($_POST['rating'] ?? 0);

if (empty($feedback_text) || $rating < 1 || $rating > 5 || $purchase_id <= 0) {
    $session->addMessage('error', 'All fields need to be filled with valid data (rating 1-5)');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

if (strlen($feedback_text) > 1000) {
    $session->addMessage('error', 'Feedback too long (max 1000 characters)');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$purchase = Purchase::getPurchaseById($db, $purchase_id);
if (!$purchase || $purchase->getClientId() !== $session->getId()) {
    $session->addMessage('error', 'You can only review your own purchases.');
    header('Location: /pages/index.php');
    exit();
}

$mockId = 0;
$date = time();

$feedback = new Feedback($mockId, $purchase_id, $rating, $feedback_text, $date);
$feedback->upload($db);
$session->addMessage('success', 'Your feedback has been sent, thanks!');
header("Location: /pages/purchase_history.php?id=" . $session->getId());
exit();
