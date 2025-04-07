<?php
declare(strict_types=1);

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

    public function getFeedbackId(): int
    {
        return $this->feedbackId;
    }

    public function getPurchaseId(): int
    {
        return $this->purchaseId;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function getReview(): string
    {
        return $this->review;
    }

    public function getDate(): int
    {
        return $this->date;
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
            strtotime($data['date'])
        );
    }


    public function setPurchaseId(int $purchaseId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Feedback SET purchaseId = :purchaseId WHERE feedbackId = :feedbackId");
        $stmt->bindParam(":purchaseId", $purchaseId);
        $stmt->bindParam(":feedbackId", $this->feedbackId);
        $stmt->execute();
        $this->purchaseId = $purchaseId;
    }

    public function setRating(float $rating, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Feedback SET rating = :rating WHERE feedbackId = :feedbackId");
        $stmt->bindParam(":rating", $rating);
        $stmt->bindParam(":feedbackId", $this->feedbackId);
        $stmt->execute();
        $this->rating = $rating;
    }

    public function setReview(string $review, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Feedback SET review = :review WHERE feedbackId = :feedbackId");
        $stmt->bindParam(":review", $review);
        $stmt->bindParam(":feedbackId", $this->feedbackId);
        $stmt->execute();
        $this->review = $review;
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
