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

if ($otherUserId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

if ($otherUserId === $userId) {
    http_response_code(400);
    echo json_encode(['error' => 'Cannot get messages with yourself']);
    exit;
}

try {
    $messages = Message::getMessagesSince($db, $userId, $otherUserId, $lastTimestamp);

    echo json_encode(array_map(function ($msg) {
        return [
            'senderId' => $msg->getSenderId(),
            'content' => htmlspecialchars($msg->getContent(), ENT_QUOTES, 'UTF-8'),
            'timestamp' => $msg->getDate(),
        ];
    }, $messages));
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
