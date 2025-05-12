<?php
declare(strict_types=1);

require_once(__DIR__ . '/../templates/service_creation.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/category.class.php');

$session = new Session();
$db = getDatabaseConnection();

$userId = $_POST['userId'] ?? null;      

if ($userId === null) {
    if ($session->isLoggedIn()) {
        $userId = $session->getId();
    } else {
        drawHeader("Unauthorized", $db, $session);
        echo "<p class='error-message'>You must be logged in to create a service.</p>";
        drawFooter();
        exit;
    }
}

$allCategories = Category::getAllCategories($db);

drawHeader("Create Service", $db, $session);
drawServiceCreationForm($allCategories, (int)$userId);
drawFooter();
