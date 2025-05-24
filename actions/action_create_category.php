<?php

declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/category.class.php');
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

$name = Security::sanitizeInput($_POST["name"] ?? '');
$icon = Security::sanitizeInput($_POST["icon"] ?? '');

if (empty($name) || empty($icon)) {
    $session->addMessage('error', 'Category name and icon are required.');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

if (strlen($name) < 2 || strlen($name) > 50) {
    $session->addMessage('error', 'Category name must be between 2 and 50 characters.');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$category = new Category(0, $name, $icon);
$category->upload($db);
$session->addMessage('success', 'Category created successfully.');
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
