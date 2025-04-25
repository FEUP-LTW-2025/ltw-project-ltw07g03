<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../templates/category.tpl.php');
require_once(__DIR__ . '/../database/complex_queries.php');

$session = new Session();
$db = getDatabaseConnection();

$services = Service::getAllServices($db);
$services_freelancers = getFreelancersForServices($db, $services);

drawHeader("Services", $db, $session);
drawCategoryResults("Services", $services_freelancers);
drawFooter();
