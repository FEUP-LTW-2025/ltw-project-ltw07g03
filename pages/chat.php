<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
//require_once(__DIR__ . '/../templates/chat.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/message.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'Login to interact with the freelancer');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$freelancer_id = intval($_GET['freelancer_id']);
$client_id = $session->getId();

$db = getDatabaseConnection();

$client = User::getUserById($db, $client_id);
$freelancer = User::getUserById($db, $freelancer_id);

if (!$client || !$freelancer) {
    $session->addMessage('error', 'User not found.');
    header('Location: /pages/index.php');
    exit();
}

$history = Message::getMessagesByParticipantsId($db, $client_id, $freelancer_id);

drawHeader("Chat", $db, $session);
//drawChat($client, $freelancer, $history);
drawFooter();
