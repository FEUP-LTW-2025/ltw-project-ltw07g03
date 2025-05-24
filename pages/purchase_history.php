<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/purchase_history.tpl.php');
require_once(__DIR__ . '/../templates/user.tpl.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/purchase.class.php');
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../database/complex_queries.php');

$session = new Session();

if ($session->getId() === null) {
    header("Location: /pages/login.php");
    exit();
}

$id = intval($_GET['id']);
$db = getDatabaseConnection();
$user = User::getUserById($db, $id);
$isOwner = $session->isLoggedIn() && $session->getId() === $user->getId();

if (!$isOwner) {
    header("Location: /pages/index.php");
    exit();
}

$purchases = Purchase::getPurchaseByClientId($db, $id);
$services = [];

foreach ($purchases as $purchase) {
    $services[] = Service::getServiceById($db, $purchase->getServiceId());
}

$services_freelancer = getFreelancersForServices($db, $services);
$purchasesWithDetails = [];

foreach ($purchases as $purchase) {
    $serviceId = $purchase->getServiceId();

    if (isset($services_freelancer[$serviceId])) {
        $purchasesWithDetails[] = [
            'purchase' => $purchase,
            'service' => $services_freelancer[$serviceId],
        ];
    }
}

drawHeader("Purchase history", $db, $session);
drawPurchaseHistory($purchasesWithDetails, $db);
drawFooter();