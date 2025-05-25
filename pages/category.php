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

$category = $_GET['name'] ?? '';
if (empty($category)) {
    $session->addMessage('error', 'Category name is required.');
    header('Location: /pages/index.php');
    exit();
}

$category = urldecode($category);

$db = getDatabaseConnection();

$categoryObj = Category::getCategoryByName($db, $category);
if (!$categoryObj) {
    $session->addMessage('error', 'Category not found.');
    header('Location: /pages/index.php');
    exit();
}

$categoryId = $categoryObj->getId();

$relatedServices = getServices_FreelancersByCategoryId($db, $categoryId);

drawHeader("Category", $db, $session);
drawCategoryResults($category, $relatedServices);
drawFooter();
