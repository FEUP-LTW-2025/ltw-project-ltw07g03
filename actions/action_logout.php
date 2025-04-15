<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$session = new Session();

$session->Logout();
header('Location: ' . $_SERVER['HTTP_REFERER']);


?>