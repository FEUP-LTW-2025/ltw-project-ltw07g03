<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$uploadDir = __DIR__ . '/../assets/images/profilePictures';
$defaultProfilePicture = 'default.jpeg';

$session = new Session();

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$mockId = 0;
$isAdmin = false;
$status = 'active';

$db = getDatabaseConnection();

function isEmptyInput(string $name, string $username, string $email, string $password): bool
{
    return (empty($name) || empty($username) || empty($email) || empty($password));
}

function isUsernameUnique(PDO $db, string $username): bool
{
    return User::getUserByUsername($db, $username) === null;
}

function isEmailUnique(PDO $db, string $email): bool
{
    return User::getUserByEmail($db, $email) === null;
}

function handlePicture(string $uploadDir, string $default, Session $session): string
{
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!isset($_FILES['profilePicture']) || $_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
        return $default;
    }

    $file = $_FILES['profilePicture'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        $session->addMessage('error', 'Profile picture type not allowed. Allowed: .jpeg, .png, .gif');
        return $default;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid('profile_', true) . '.' . $ext;
    $targetPath = $uploadDir . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'assets/images/profilePictures/' . $filename;
    } else {
        $session->addMessage('error', 'Failed to upload image. Default picture used.');
        return $default;
    }
}

if (!isEmptyInput($name, $username, $email, $password)) {
    if (isUsernameUnique($db, $username) && isEmailUnique($db, $email)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $profilePictureURL = handlePicture($uploadDir, $defaultProfilePicture, $session);
        $user = new User($mockId, $name, $username, $email, $hashedPassword, $isAdmin, $profilePictureURL, $status);
        $user->upload($db);

        $session->setId($user->getId());
        $session->setName($user->getName());
        $session->addMessage('success', 'SignUp successful!');
        header('Location: /');
    } else {
        $session->addMessage('error', 'Username or Email already used, try again');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    $session->addMessage('error', 'Failed to SignUp due to missing fields');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


