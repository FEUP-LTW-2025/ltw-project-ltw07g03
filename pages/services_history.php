<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/services_history.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/complex_queries.php');
require_once(__DIR__ . '/../model/user.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to view services history.');
    header("Location: /pages/login.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    $session->addMessage('error', 'Invalid user ID.');
    header("Location: /pages/index.php");
    exit();
}

$db = getDatabaseConnection();
$user = User::getUserById($db, $id);

if (!$user) {
    $session->addMessage('error', 'User not found.');
    header("Location: /pages/index.php");
    exit();
}

$isOwner = $session->getId() === $user->getId();

if (!$isOwner) {
    $session->addMessage('error', 'You can only view your own services history.');
    header("Location: /pages/index.php");
    exit();
}

$purchases = getPurchasesByFreelancerId($db, $id);

drawHeader("History", $db, $session);
drawServicesHistory($db, $purchases, $session);
drawFooter();
