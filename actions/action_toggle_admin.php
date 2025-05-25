<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

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

$currentUser = User::getUserById($db, $session->getId());
if (!$currentUser || !$currentUser->IsAdmin()) {
    $session->addMessage('error', 'Access denied. Admin privileges required.');
    header('Location: /pages/index.php');
    exit();
}

$userId = intval($_POST['userId'] ?? 0);
$isAdmin = ($_POST['isAdmin'] ?? '') === '1';

if ($userId <= 0) {
    $session->addMessage('error', 'Invalid user ID.');
    header('Location: /pages/admin_dashboard.php');
    exit();
}

if ($userId === $session->getId() && !$isAdmin) {
    $session->addMessage('error', 'You cannot remove your own admin privileges.');
    header('Location: /pages/admin_dashboard.php');
    exit();
}

$user = User::getUserById($db, $userId);
if (!$user) {
    $session->addMessage('error', 'User not found.');
    header('Location: /pages/admin_dashboard.php');
    exit();
}

$user->setIsAdmin($isAdmin, $db);
$session->addMessage('success', 'User privileges updated successfully.');
header("Location: /pages/user.php?id=$userId");
exit();
