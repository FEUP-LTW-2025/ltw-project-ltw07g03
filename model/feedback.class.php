<?php
declare(strict_types=1);

class Feedback
{
    public int $feedbackId;
    public int $purchaseId;
    public float $rating;
    public string $review;
    public int $date;

    function __construct(int $feedbackId, int $purchaseId, int $rating, string $review, int $date)
    {
        $this->feedbackId = $feedbackId;
        $this->purchaseId = $purchaseId;
        $this->rating = $rating;
        $this->review = $review;
        $this->date = $date;
    }
}
