<?php
declare(strict_types=1);

require_once(__DIR__ . '/../model/purchase.class.php');
require_once(__DIR__ . '/../model/user.class.php');

class Feedback
{
    private int $feedbackId;
    private int $purchaseId;
    private float $rating;
    private string $review;
    private int $date;

    public function __construct(int $feedbackId, int $purchaseId, float $rating, string $review, int $date)
    {
        $this->feedbackId = $feedbackId;
        $this->purchaseId = $purchaseId;
        $this->rating = $rating;
        $this->review = $review;
        $this->date = $date;
    }

    public static function getFeedbackById(PDO $db, int $id): ?Feedback
    {
        $stmt = $db->prepare("SELECT * FROM Feedback WHERE feedbackId = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }
        return new Feedback(
            intval($data['feedbackId']),
            intval($data['purchaseId']),
            floatval($data['rating']),
            $data['review'],
            $data['date']
        );
    }

    public static function getFeedback_AuthorByServiceId(PDO $db, int $service_id): ?array
    {

        $stmt = $db->prepare("SELECT * FROM Feedback F JOIN Purchase P ON P.purchaseId = F.purchaseId  WHERE P.serviceId = :service_id");
        $stmt->bindParam(":service_id", $service_id, PDO::PARAM_INT);
        $stmt->execute();

        $feedbacks = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $feedbackId = intval($data['feedbackId']);
            $purchaseId = intval($data['purchaseId']);
            $rating = floatval($data['rating']);
            $review = $data['review'];
            $date = $data['date'];

            $feedback = new Feedback(
                $feedbackId,
                $purchaseId,
                $rating,
                $review,
                $date
            );
            $author = $feedback->getAuthor($db);

            $feedbacks[] = ['feedback' => $feedback, 'author' => $author];

        }

        return $feedbacks;
    }

    public function getAuthor(PDO $db): User
    {
        $purchase = Purchase::getPurchaseById($db, $this->purchaseId);
        $author = User::getUserById($db, $purchase->getClientId());
        return $author;
    }

    public function getFeedbackId(): int
    {
        return $this->feedbackId;
    }

    public function getPurchaseId(): int
    {
        return $this->purchaseId;
    }

    public function setPurchaseId(int $purchaseId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Feedback SET purchaseId = :purchaseId WHERE feedbackId = :feedbackId");
        $stmt->bindParam(":purchaseId", $purchaseId);
        $stmt->bindParam(":feedbackId", $this->feedbackId);
        $stmt->execute();
        $this->purchaseId = $purchaseId;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Feedback SET rating = :rating WHERE feedbackId = :feedbackId");
        $stmt->bindParam(":rating", $rating);
        $stmt->bindParam(":feedbackId", $this->feedbackId);
        $stmt->execute();
        $this->rating = $rating;
    }

    public function getReview(): string
    {
        return $this->review;
    }

    public function setReview(string $review, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Feedback SET review = :review WHERE feedbackId = :feedbackId");
        $stmt->bindParam(":review", $review);
        $stmt->bindParam(":feedbackId", $this->feedbackId);
        $stmt->execute();
        $this->review = $review;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function setDate(int $date, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Feedback SET date = :date WHERE feedbackId = :feedbackId");
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":feedbackId", $this->feedbackId);
        $stmt->execute();
        $this->date = $date;
    }

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
}
