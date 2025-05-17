<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/search.tpl.php');
require_once(__DIR__ . '/../templates/category.tpl.php'); 
require_once(__DIR__ . '/../templates/authentication.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/category.class.php');
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../database/complex_queries.php');

$session = new Session();

$category = $_GET['name'] ?? 'Unknown';
$category = urldecode($category);

$db = getDatabaseConnection();

$categoryId = Category::getCategoryByName($db, $category);
$categoryId = $categoryId->getId();

$relatedServices = getServices_FreelancersByCategoryId($db, $categoryId);

drawHeader("Category", $db, $session);
drawCategoryResults($category, $relatedServices, $db);
drawFooter();
