<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/admin_dashboard.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/category.class.php');

$session = new Session();
$db = getDatabaseConnection();
if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to access the admin dashboard.');
    header('Location: /pages/login.php');
    exit();
}
$user = User::getUserById($db, $session->getId());
if (!$user || !$user->isAdmin()) {
    $session->addMessage('error', 'Access denied. Admin privileges required.');
    header('Location: /pages/index.php');
    exit();
}

$categories = Category::getAllCategories($db);

drawHeader("Admin Dashboard", $db, $session);
drawAdminDashboard($categories, $session);
drawFooter();
