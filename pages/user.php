<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/user.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../model/message.class.php');


$session = new Session();

$id = intval($_GET['id']);
$db = getDatabaseConnection();
$user = User::getUserById($db, $id);
$services = Service::getServicesByUserId($db, $id);

$isOwner = false;
$account = null;

//If user not found, show error
if ($user === null) {
    drawHeader("User Not Found", $db, $session);
    echo "<section class='error-section'><h2>User not found.</h2><p>The requested user does not exist.</p></section>";
    drawFooter();
    exit;
}

if ($session->isLoggedIn()) {
    $sessionId = $session->getId();
    $account = User::getUserById($db, $sessionId);
    $isOwner = $account !== null && $sessionId === $user->getId();
}

$relatedUserIds = Message::getConversationUsersByUserId($db, $id);

$conversationUsers = [];
if (is_array($relatedUserIds)) {
    foreach ($relatedUserIds as $otherUserId) {
        $otherUser = User::getUserById($db, $otherUserId);
        if ($otherUser !== null) {
            $conversationUsers[] = $otherUser;
        }
    }
}

drawHeader($user->getName(), $db, $session);

if ($account !== null && $account->isAdmin() && $account->getId() !== $user->getId() && !$user->isAdmin()) {
    drawAdminStatusBar($user);
}

if ($isOwner) {
    drawEditableUserProfile($user, $conversationUsers);
} else {
    drawUserProfile($user);
}

drawUserServices($user, $services ?? []);

?> 
<script src="/javascript/image_preview.js"></script>
<?php

drawFooter();
