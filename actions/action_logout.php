<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

$session->addMessage('success', 'You have been logged out successfully.');
$session->Logout();
header('Location: /pages/index.php');
exit();
