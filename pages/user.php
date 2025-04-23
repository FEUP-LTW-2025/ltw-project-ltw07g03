<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/user.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/service.class.php');

$session = new Session();

$id = intval($_GET['id']);
$db = getDatabaseConnection();
$user = User::getUserById($db, $id);
$services = Service::getServicesByUserId($db, $id);
$isOwner = $session->isLoggedIn() && $session->getId() === $user->getId();

drawHeader($user->getName(), $session);
if ($isOwner) {
    drawEditableUserProfile($user);
} else {
    drawUserProfile($user);
}
if ($services != []) {
    drawUserServices($user, $services);
}
drawFooter();
