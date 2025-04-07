<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/home.tpl.php');

$session = new Session();

$categories = [
    ['name' => 'Programming & Tech', 'icon' => '💻'],
    ['name' => 'Graphics and Design', 'icon' => '🎨'],
    ['name' => 'Digital Marketing', 'icon' => '📈'],
    ['name' => 'Video & Animation', 'icon' => '🎬'],
    ['name' => 'Music & Audio', 'icon' => '🎧'],
    ['name' => 'Business', 'icon' => '💼']
];

drawHeader("Home", $session);
drawHomeHeading();
drawHomeSearch();
drawHomeCategories($categories);
drawFooter();
