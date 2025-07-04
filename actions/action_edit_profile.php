<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../utils/image_upload.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to edit your profile.');
    header('Location: /pages/login.php');
    exit;
}

if (!Security::validateCSRFToken($session)) {
    $session->addMessage('error', 'Invalid request. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$db = getDatabaseConnection();
$loggedInId = $session->getId();
$profileId = intval($_POST['id'] ?? 0);

if ($profileId !== $loggedInId) {
    $session->addMessage('error', 'You can only edit your own profile.');
    header('Location: /pages/index.php');
    exit;
}

$user = User::getUserById($db, $profileId);
if ($user === null) {
    $session->addMessage('error', 'User not found.');
    header('Location: /pages/index.php');
    exit;
}

$name = Security::sanitizeInput($_POST['name'] ?? '');
$username = Security::sanitizeInput($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$status = $_POST['status'] ?? '';

if (
    $name === '' || $username === '' || $email === '' ||
    !in_array($status, ['active', 'inactive']) ||
    !Security::validateEmail($email) ||
    strlen($name) < 2 || strlen($name) > 100 ||
    strlen($username) < 3 || strlen($username) > 50 ||
    !preg_match('/^[a-zA-Z0-9_]+$/', $username)
) {
    $session->addMessage('error', 'All fields are required and must be valid.');
    header("Location: /pages/user.php?id=$profileId");
    exit;
}

$existing = User::getUserByUsername($db, $username);
if ($existing !== null && $existing->getId() !== $profileId) {
    $session->addMessage('error', 'Username already taken.');
    header("Location: /pages/user.php?id=$profileId");
    exit;
}
$existing = User::getUserByEmail($db, $email);
if ($existing !== null && $existing->getId() !== $profileId) {
    $session->addMessage('error', 'Email already in use.');
    header("Location: /pages/user.php?id=$profileId");
    exit;
}

$uploadDir = __DIR__ . '/../assets/images/pfps/';
$uploadUrl = '/assets/images/pfps/';

$currentPic = $user->getProfilePicture();

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxFileSize = 2 * 1024 * 1024;

$newPic = $currentPic;
if (!empty($_FILES['profilePicture']['tmp_name'])) {
    if (!Security::validateFileUpload($_FILES['profilePicture'], $allowedTypes, $maxFileSize)) {
        $session->addMessage('error', 'Invalid profile picture. Only images under 2MB are allowed.');
        header("Location: /pages/user.php?id=$profileId");
        exit();
    }

    $newPic = handleSingleImageUpload(
        $_FILES['profilePicture'],
        $uploadDir,
        $uploadUrl,
        $currentPic,
        $session
    );
}

if ($name !== $user->getName()) {
    $user->setName($name, $db);
    $session->setName($name);
}
if ($username !== $user->getUsername()) {
    $user->setUsername($username, $db);
}
if ($email !== $user->getEmail()) {
    $user->setEmail($email, $db);
}
if ($status !== $user->getStatus()) {
    $user->setStatus($status, $db);
}
if ($newPic !== $currentPic) {
    $user->setProfilePicture($newPic, $db);
}

$session->addMessage('success', 'Profile updated successfully.');
header("Location: /pages/user.php?id=$profileId");
exit();
