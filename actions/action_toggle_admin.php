<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$session = new Session();

$db = getDatabaseConnection();
$userId = intval($_POST['userId']);
$isAdmin = $_POST['isAdmin'] === '1';

$user = User::getUserById($db, $userId);
$user->setIsAdmin($isAdmin, $db);

header("Location: /pages/user.php?id=$userId");
