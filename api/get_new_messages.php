<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/message.class.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$db = getDatabaseConnection();
$userId = $session->getId();
$otherUserId = intval($_GET['user_id'] ?? 0);
$lastTimestamp = intval($_GET['since'] ?? 0);

// Buscar mensagens com timestamp maior
$messages = Message::getMessagesSince($db, $userId, $otherUserId, $lastTimestamp);

header('Content-Type: application/json');
echo json_encode(array_map(function($msg) {
    return [
        'senderId' => $msg->getSenderId(),
        'content' => $msg->getContent(),
        'timestamp' => $msg->getDate(),
    ];
}, $messages));
