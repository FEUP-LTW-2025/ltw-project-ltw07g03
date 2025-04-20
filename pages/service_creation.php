<?php
declare(strict_types=1);

require_once(__DIR__ . '/../templates/service_creation.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/category.class.php');

$session = new Session();
$db = getDatabaseConnection();

$userId = (int)$_POST['userId'];

$allCategories = Category::getAllCategories($db);

drawHeader("Create Service", $session);
drawServiceCreationForm($allCategories, $userId);
drawFooter();
