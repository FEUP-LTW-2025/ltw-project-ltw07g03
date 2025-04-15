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



$session = new Session();

$category = $_GET['name'] ?? 'Unknown';
$category = urldecode($category);

/*$services = [
    'Programming & Tech' => ['Website Development', 'Game Development', 'Support & IT', 'Cybersecurity'],
    'Graphics and Design' => ['Logo Design', 'Website Design', 'Illustration', 'Architecture and Interior Design'],
    'Digital Marketing' => ['Marketing Strategy', 'Video Marketing', 'Social Media Marketing', 'Influencer Marketing'],
    'Video & Animation' => ['Video Editing', 'Visual Effects', 'Character Animation', '3D Product Animation'],
    'Music & Audio' => ['Voice Over', 'Audio Editing', 'Sound Design', 'Podcast Production'],
    'Business' => ['Sales', 'Legal Research', 'Business Plan', 'Project Management'],
];

$selectedServices = $services[$category] ?? [];
*/

$db = getDatabaseConnection();

$categoryId = Category::getCategoryByName($db, $category);
$categoryId = $categoryId->getId();

$relatedServices = Service::getServicesByCategoryId($db, $categoryId);



drawHeader("Category", $session);
drawCategoryResults($category, $relatedServices);
drawFooter();
