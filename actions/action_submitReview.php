<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/feedback.class.php');

$session = new Session();
$db = getDatabaseConnection();

$purchase_id = intval($_POST['purchase_id']);
$feedback = trim($_POST['feedback']);
$rating = intval($_POST['rating']);
$mockId = 0;
$date = time(); 


if(isset($feedback) && isset($rating)){
    $feedback = new Feedback($mockId, $purchase_id, $rating, $feedback, $date);
    $feedback->upload($db);
    $session->addMessage('success', 'Your feedback has been sent, thanks!');
    header("Location: /pages/user.php?id=" . $session->getId());

} else{
    $session->addMessage('error', 'All fields need to be filled');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}





/*

public function upload(PDO $db): void
    {
        $stmt = $db->prepare(
            "INSERT INTO Feedback (purchaseId, rating, review, date) 
         VALUES (:purchaseId, :rating, :review, :date)"
        );

        $stmt->bindParam(":purchaseId", $this->purchaseId);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":review", $this->review);
        $stmt->bindParam(":date", $this->date);

        $stmt->execute();
    }

*/ 
?>