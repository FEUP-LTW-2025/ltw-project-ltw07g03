<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$session = new Session();

if (!Security::validateCSRFToken($session)) {
    $session->addMessage("error", "Invalid security token");
    header('Location: /pages/login.php');
    exit();
}

$username = Security::sanitizeInput($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $session->addMessage("error", "The fields cannot be empty");
    header('Location: /pages/login.php');
    exit();
}

$db = getDatabaseConnection();
$user = User::getUserByUsername($db, $username);

if ($user && password_verify($password, $user->getPassword())) {
    $session->setId($user->getId());
    $session->setName($user->getName());
    $session->addMessage('success', 'Login successful!');
    header('Location: /pages/index.php');
} else {
    $session->addMessage('error', 'Invalid username or password');
    header('Location: /pages/login.php');
}
exit();
