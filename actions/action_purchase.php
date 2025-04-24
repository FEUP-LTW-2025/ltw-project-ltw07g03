<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/purchase.class.php');

$session = new Session();
$db = getDatabaseConnection();


if(isset($_POST['serviceId']) && isset($_POST['clientId'])){

    $serviceId = intval($_POST['serviceId']);
    $clientId = intval($_POST['clientId']);

} else {
    $session->addMessage("error", "missing parameters");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$mockId = 0;
$status = 'pending';
$date = time();


$purchase = new Purchase($mockId, $serviceId, $clientId, $date, $status);
$purchase->upload($db);


$session->addMessage('sucess', 'Purchase successful!');
header('Location: /pages/services.php');
exit();

?>