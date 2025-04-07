<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/search.tpl.php');

$session = new Session();

$searchQuery = $_GET['query'] ?? '';
$searchQuery = strtolower(trim($searchQuery));

$allServices = [
    'Website Development', 'Game Development', 'Support & IT', 'Cybersecurity',
    'Logo Design', 'Website Design', 'Illustration', 'Architecture and Interior Design',
    'Marketing Strategy', 'Video Marketing', 'Social Media Marketing', 'Influencer Marketing',
    'Video Editing', 'Visual Effects', 'Character Animation', '3D Product Animation',
    'Voice Over', 'Audio Editing', 'Sound Design', 'Podcast Production',
    'Sales', 'Legal Research', 'Business Plan', 'Project Management'
];

$results = [];

foreach ($allServices as $service) {
    if (stripos($service, $searchQuery) !== false) {
        $results[] = $service;
    }
}

drawHeader("Home", $session);
drawSearchResults($searchQuery, $results);
drawFooter();
