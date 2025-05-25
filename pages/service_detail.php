<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/service_detail.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/complex_queries.php');
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../model/feedback.class.php');
require_once(__DIR__ . '/../database/complex_queries.php');

$session = new Session();
$db = getDatabaseConnection();

$serviceId = isset($_GET['id']) ? intval($_GET['id']) : 0;

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
$feedbacks_author = Feedback::getFeedback_AuthorByServiceId($db, $serviceId);

$isOwner = $service->getFreelancerId() === $session->getId();

drawHeader("Service Detail", $db, $session);

if($isOwner){
    drawEditableServiceDetail($service_freelancer[$serviceId], $feedbacks_author);
} else{
    drawServiceDetail($service_freelancer[$serviceId], $feedbacks_author);
}
drawFooter();
