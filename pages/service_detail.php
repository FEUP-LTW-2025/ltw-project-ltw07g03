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

// 1. Obtém o serviço com o ID fornecido
$service = Service::getServiceById($db, $serviceId);  // Aqui deve haver uma função que recupere o serviço pelo ID.

if (!$service) {
    $session->addMessage('error', 'Service not found.');
    header('Location: /pages/index.php');
    exit();
}

// 2. Obtém os freelancers para os serviços encontrados
$service_freelancer = getFreelancersForServices($db, array($service));  // Agora $service já está inicializado

// 3. Obtém os feedbacks para o serviço
$feedbacks_author = Feedback::getFeedback_AuthorByServiceId($db, $serviceId);

drawHeader("Service Detail", $session);
drawServiceDetail($service_freelancer[0], $feedbacks_author);  // Aqui passo o primeiro serviço (pois é um array)
drawFooter();
