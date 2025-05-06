<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/chat.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/message.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'Login to interact with the freelancer');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$other_userId = intval($_GET['user_id']); //quem quer contactar
$userid = $session->getId(); //quem abriu o chat

$db = getDatabaseConnection();

$other_user = User::getUserById($db, $other_userId);
$user = User::getUserById($db, $userid);

if (!$user || !$other_user) {
    $session->addMessage('error', 'User not found.');
    header('Location: /pages/index.php');
    exit();
}

$history = Message::getMessagesByParticipantsId($db, $userid, $other_userId);

drawHeader("Chat", $db, $session);
drawChat($user, $other_user, $history);
drawFooter();
