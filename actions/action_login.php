<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$session = new Session();

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {

    $session->addMessage("error", "The fields can not be empty");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$db = getDatabaseConnection();
$user = User::getUserByUsername($db, $username);

if ($user && password_verify($password, $user->getPassword())) {
    $session->setId($user->getId());
    $session->setName($user->getName());
    $session->addMessage('success', 'Login successful!');
    header('Location: /');
    exit();

} else {
    $session->addMessage('error', 'Login Failed');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
