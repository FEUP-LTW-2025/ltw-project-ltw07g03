<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/message.class.php');

$session = new Session();
$db = getDatabaseConnection();

$receiverId = intval($_POST['receiver_id']);
$content = trim($_POST['msg_content']);

if (!isset($receiverId, $content) || empty($content)) {
    echo json_encode(['success' => false, 'error' => 'Please fill the message field']);
    exit();
}

$senderId = $session->getId();
$date = time();
$mockId = 0;

$message = new Message($mockId, $senderId, $receiverId, $content, $date);
$message->upload($db);

exit();