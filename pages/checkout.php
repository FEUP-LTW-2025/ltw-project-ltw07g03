<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/home.tpl.php');
require_once(__DIR__ . '/../templates/checkout.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/complex_queries.php');
require_once(__DIR__ . '/../model/service.class.php');


$db = getDatabaseConnection();
$session = new Session();

$serviceId = isset($_GET['serviceId']) ? intval($_GET['serviceId']) : 0;

if ($serviceId === 0) {
    $session->addMessage('error', 'Invalid service ID.');
    header('Location: /pages/index.php');
    exit();
}

$service = Service::getServiceById($db, $serviceId);

if (!$service) {
    $session->addMessage('error', 'Service not found.');
    header('Location: /pages/index.php');
    exit();
}

$service_freelancer = getFreelancersForServices($db, array($service));

if(!$session->getId()){
    $session->addMessage('error', 'Login to buy services');
    header('Location: /pages/login.php');
    exit();
}


drawHeader("Service Detail", $session);
drawCheckoutForm($service_freelancer[0], $session->getId());
drawFooter();
?>

