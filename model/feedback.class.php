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

    public function setFeedbackId(int $feedbackId): void
    {
        $this->feedbackId = $feedbackId;
    }

    public function setPurchaseId(int $purchaseId): void
    {
        $this->purchaseId = $purchaseId;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function setReview(string $review): void
    {
        $this->review = $review;
    }

    public function setDate(int $date): void
    {
        $this->date = $date;
    }
}
