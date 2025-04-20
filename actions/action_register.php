<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/image_upload.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$uploadDir = __DIR__ . '/../assets/images/pfps/';
$uploadUrl = '/assets/images/pfps/';
$defaultProfilePicture = $uploadUrl . 'default.jpeg';

$session = new Session();

$name = $_POST['name'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

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

if (!isEmptyInput($name, $username, $email, $password)) {
    if (isUsernameUnique($db, $username) && isEmailUnique($db, $email)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $profilePictureURL = handleImageUpload('profilePicture', $uploadDir, $uploadUrl, $defaultProfilePicture, $session);

        $user = new User($mockId, $name, $username, $email, $hashedPassword, $isAdmin, $profilePictureURL, $status);
        $user->upload($db);

        $session->setId($user->getId());
        $session->setName($user->getName());
        $session->addMessage('success', 'SignUp successful!');

        header("Location: /pages/user.php?id=" . $user->getId());
        exit();
    } else {
        $session->addMessage('error', 'Username or Email already used, try again');
    }
} else {
    $session->addMessage('error', 'Failed to SignUp due to missing fields');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
