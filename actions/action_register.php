<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../utils/image_upload.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$uploadDir = __DIR__ . '/../assets/images/pfps/';
$uploadUrl = '/assets/images/pfps/';
$defaultProfilePicture = $uploadUrl . 'default.jpeg';

$session = new Session();

if (!Security::validateCSRFToken($session)) {
    $session->addMessage('error', 'Invalid request. Please try again.');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$name = Security::sanitizeInput($_POST['name'] ?? '');
$username = Security::sanitizeInput($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$mockId = 0;
$isAdmin = false;
$status = 'active';

$db = getDatabaseConnection();

function isEmptyInput(string $name, string $username, string $email, string $password): bool
{
    return (empty($name) || empty($username) || empty($email) || empty($password));
}

function isValidInput(string $name, string $username, string $email, string $password): bool
{
    return Security::validateEmail($email) &&
        Security::validatePassword($password) &&
        strlen($name) >= 2 && strlen($name) <= 100 &&
        strlen($username) >= 3 && strlen($username) <= 50 &&
        preg_match('/^[a-zA-Z0-9_]+$/', $username);
}

function isUsernameUnique(PDO $db, string $username): bool
{
    return User::getUserByUsername($db, $username) === null;
}

function isEmailUnique(PDO $db, string $email): bool
{
    return User::getUserByEmail($db, $email) === null;
}

if (!isEmptyInput($name, $username, $email, $password) && isValidInput($name, $username, $email, $password)) {
    if (isUsernameUnique($db, $username) && isEmailUnique($db, $email)) {
        $hashedPassword = Security::hashPassword($password);
        $profilePictureURL = handleSingleImageUpload($_FILES['profilePicture'] ?? [], $uploadDir, $uploadUrl, $defaultProfilePicture, $session);

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
    $session->addMessage('error', 'Failed to SignUp: Invalid or missing fields. Password must be at least 8 characters with letters and numbers.');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();