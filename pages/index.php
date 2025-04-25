<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/category.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/home.tpl.php');
require_once(__DIR__ . '/../utils/session.php');

$db = getDatabaseConnection();
$session = new Session();

$categories = Category::getAllCategories($db);

drawHeader("Home", $db, $session);
drawHomeHeading();
drawHomeSearch();
drawHomeCategories($categories);
drawFooter();
