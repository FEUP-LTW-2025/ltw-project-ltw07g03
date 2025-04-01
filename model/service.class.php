<?php
declare(strict_types=1);

class Service
{
    public int $id;
    public int $freelancerId;
    public string $category;
    public string $title;
    public float $price;
    public int $deliveryTime;
    public string $description;
    public string $status;
    public array $images;

    public function __construct(int $id, int $freelancerId, string $category, string $title, float $price, int $deliveryTime, string $description, string $status, array $images)
    {
        $this->id = $id;
        $this->freelancerId = $freelancerId;
        $this->category = $category;
        $this->title = $title;
        $this->price = $price;
        $this->deliveryTime = $deliveryTime;
        $this->description = $description;
        $this->status = $status;
        $this->images = $images;
    }
}
