<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/message.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    echo json_encode(['success' => false, 'error' => 'You must be logged in to send messages']);
    exit();
}

if (!Security::validateCSRFToken($session)) {
    echo json_encode(['success' => false, 'error' => 'Invalid request token']);
    exit();
}

$db = getDatabaseConnection();

$receiverId = intval($_POST['receiver_id'] ?? 0);
$content = trim($_POST['msg_content'] ?? '');

if (!isset($receiverId, $content) || empty($content) || $receiverId <= 0) {
    echo json_encode(['success' => false, 'error' => 'Please fill the message field with valid data']);
    exit();
}

if (strlen($content) > 1000) {
    echo json_encode(['success' => false, 'error' => 'Message too long (max 1000 characters)']);
    exit();
}

$senderId = $session->getId();

if ($senderId === $receiverId) {
    echo json_encode(['success' => false, 'error' => 'You cannot send messages to yourself']);
    exit();
}

$date = time();
$mockId = 0;

$message = new Message($mockId, $senderId, $receiverId, $content, $date);
$message->upload($db);

echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
exit();
