<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/message.class.php');

header('Content-Type: application/json');

$session = new Session();
$db = getDatabaseConnection();


$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['receiver_id'], $data['content']) || empty(trim($data['content']))) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit();
}

$senderId = $session->getId();
$receiverId = intval($data['receiver_id']);
$content = trim($data['content']);
$date = time();

$mockId = 0; 
$message = new Message($mockId, $senderId, $receiverId, 0, $content, $date);
$message->upload($db);

$messageId = Message::getLastInsertedId($db);

echo json_encode([
    'messageId' => $messageId,
    'senderId' => $senderId,
    'receiverId' => $receiverId,
    'content' => $content,
    'date' => date('d/m/Y H:i', $date)
]);
