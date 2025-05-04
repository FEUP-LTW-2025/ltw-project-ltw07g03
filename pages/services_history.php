<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/services_history.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/complex_queries.php');

$session = new Session();

if ($session->getId() === null) {
    header("Location: /pages/login.php");
    exit();
}

$id = intval($_GET['id']);
$db = getDatabaseConnection();
$user = User::getUserById($db, $id);
$isOwner = $session->isLoggedIn() && $session->getId() === $user->getId();

if (!$isOwner) {
    header("Location: /pages/index.php");
    exit();
}

$purchases = getPurchasesByFreelancerId($db, $id);

drawHeader("History", $db, $session);
drawServicesHistory($db, $purchases);
drawFooter();
