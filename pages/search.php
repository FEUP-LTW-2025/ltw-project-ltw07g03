<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/search.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../templates/category.tpl.php');
require_once(__DIR__ . '/../database/complex_queries.php');

$session = new Session();
$db = getDatabaseConnection();

$searchQuery = trim($_GET['query'] ?? '');

if (empty($searchQuery)) {
    $session->addMessage('error', 'Please enter a search term.');
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/pages/index.php'));
    exit();
}

$single_word = explode(" ", $searchQuery);

$relatedServices = getRelatedServices($db, $single_word);
$services_info = getFreelancersForServices($db, $relatedServices);

drawHeader("Search", $db, $session);
drawCategoryResults("_" . $searchQuery, $services_info);
drawFooter();

function getRelatedServices(PDO $db, array $words): array
{
    $service_info = Service::getAllServices($db);
    $results = [];

    foreach ($words as $word) {
        foreach ($service_info as $service) {
            if (stripos($service->getTitle(), $word) !== false) {
                $results[] = $service;
            }
        }
    }

    return $results;
}
