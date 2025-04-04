<?php
declare(strict_types=1);

class Service
{
    private int $id;
    private int $freelancerId;
    private string $category;
    private string $title;
    private float $price;
    private int $deliveryTime;
    private string $description;
    private string $status;
    private float $rating;
    private array $images;

    public function __construct(
        int    $id,
        int    $freelancerId,
        string $category,
        string $title,
        float  $price,
        int    $deliveryTime,
        string $description,
        string $status,
        float  $rating,
        array  $images
    )
    {
        $this->id = $id;
        $this->freelancerId = $freelancerId;
        $this->category = $category;
        $this->title = $title;
        $this->price = $price;
        $this->deliveryTime = $deliveryTime;
        $this->description = $description;
        $this->status = $status;
        $this->rating = $rating;
        $this->images = $images;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFreelancerId(): int
    {
        return $this->freelancerId;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDeliveryTime(): int
    {
        return $this->deliveryTime;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setFreelancerId(int $freelancerId): void
    {
        $this->freelancerId = $freelancerId;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setDeliveryTime(int $deliveryTime): void
    {
        $this->deliveryTime = $deliveryTime;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }
}
