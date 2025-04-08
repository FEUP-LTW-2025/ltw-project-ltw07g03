<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/user.class.php');

$session = new Session();


$username = $_POST['username'];
$password = $_POST['password'];

if(empty($username) || empty($password)){

    echo "Pleast type something!!";

}

$db = getDatabaseConnection();

$user = User::getUserByPassword($db,$username,$password);

if($user){
    $session->setId($user->getId());
    $session->setName($user->getName());
    echo "LOGIN SUCCEFULLY";
} else{
    $session->addMessage('error', 'Credenciais incorretas.');

    $messages = $session->getMessages();

    foreach ($messages as $message) {
        echo "Tipo: " . $message['type'] . "<br>";
        echo "Texto: " . $message['text'] . "<br><br>";
    }




}









?>