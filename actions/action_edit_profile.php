<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', 'You must be logged in to edit your profile.');
    header('Location: /pages/login.php');
    exit;
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

$name = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$status = $_POST['status'] ?? '';

if ($name === '' || $username === '' || $email === '' || !in_array($status, ['active', 'inactive'])) {
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

function handlePicture(string $uploadDir, string $uploadUrl, string $default, Session $session): string
{
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    if (!isset($_FILES['profilePicture']) || $_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
        return $default;
    }
    $file = $_FILES['profilePicture'];
    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed)) {
        $session->addMessage('error', 'Invalid image type.');
        return $default;
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $name = uniqid('profile_', true) . '.' . $ext;
    $dest = $uploadDir . $name;
    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return $uploadUrl . $name;
    } else {
        $session->addMessage('error', 'Failed to upload image.');
        return $default;
    }
}

$currentPic = $user->getProfilePicture();
$newPic = handlePicture($uploadDir, $uploadUrl, $currentPic, $session);

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
