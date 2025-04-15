<?php
declare(strict_types=1);

class Service
{
    private int $id;
    private int $freelancerId;
    private int $categoryId;
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
        int    $categoryId,
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
        $this->categoryId = $categoryId;
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

    public function getCategoryId(): int
    {
        return $this->categoryId;
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

    public static function getServiceById(PDO $db, int $id): ?Service
    {
        $stmt = $db->prepare("SELECT * FROM Service WHERE serviceId = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        $stmt = $db->prepare("SELECT mediaURL FROM ServiceMedia WHERE serviceId = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $images = $stmt->fetchAll();

        return new Service(
            intval($data['serviceId']),
            intval($data['freelancerId']),
            intval($data['categoryId']),
            $data['title'],
            floatval($data['price']),
            intval($data['deliveryTime']),
            $data['description'],
            $data['status'],
            floatval($data['rating']),
            $images
        );
    }

    
    public static function getServicesByCategoryId(PDO $db, int $cat_id): array
{
    $stmt = $db->prepare("SELECT * FROM Service WHERE categoryId = :cat_id");
    $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
    $stmt->execute();

    $services = [];

    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $serviceId = intval($data['serviceId']);

        $mediaStmt = $db->prepare("SELECT mediaURL FROM ServiceMedia WHERE serviceId = :id");
        $mediaStmt->bindParam(":id", $serviceId, PDO::PARAM_INT);
        $mediaStmt->execute();
        $images = $mediaStmt->fetchAll(PDO::FETCH_COLUMN);

        $services[] = new Service(
            $serviceId,
            intval($data['freelancerId']),
            intval($data['categoryId']),
            $data['title'],
            floatval($data['price']),
            intval($data['deliveryTime']),
            $data['description'],
            $data['status'],
            floatval($data['rating']),
            $images
        );
    }

    return $services;
}



    public function setTitle(string $title, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET title = :title WHERE serviceId = :id");
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->title = $title;
    }

    public function setPrice(float $price, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET price = :price WHERE serviceId = :id");
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->price = $price;
    }

    public function setDeliveryTime(int $deliveryTime, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET deliveryTime = :deliveryTime WHERE serviceId = :id");
        $stmt->bindParam(":deliveryTime", $deliveryTime);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->deliveryTime = $deliveryTime;
    }

    public function setDescription(string $description, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET description = :description WHERE serviceId = :id");
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->description = $description;
    }

    public function setStatus(string $status, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET status = :status WHERE serviceId = :id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->status = $status;
    }

    public function setCategoryId(int $categoryId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET categoryId = :categoryId WHERE serviceId = :id");
        $stmt->bindParam(":categoryId", $categoryId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->categoryId = $categoryId;
    }

    public function setFreelancerId(int $freelancerId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET freelancerId = :freelancerId WHERE serviceId = :id");
        $stmt->bindParam(":freelancerId", $freelancerId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->freelancerId = $freelancerId;
    }

    public function setRating(float $rating, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET rating = :rating WHERE serviceId = :id");
        $stmt->bindParam(":rating", $rating);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->rating = $rating;
    }

    public function setImages(array $images): void
    {
        // TODO
        $this->images = $images;
    }

    public function upload(PDO $db): void
    {
        $stmt = $db->prepare(
            "INSERT INTO Service (freelancerId, categoryId, title, price, deliveryTime, description, status)
            VALUES (:freelancerId, :categoryId, :title, :price, :deliveryTime, :description, :status)"
        );

        $stmt->bindParam(":freelancerId", $this->freelancerId);
        $stmt->bindParam(":categoryId", $this->categoryId);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":deliveryTime", $this->deliveryTime);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);

        $stmt->execute();

        $this->id = intval($db->lastInsertId());

        $stmt = $db->prepare("INSERT INTO ServiceMedia (serviceId, mediaURL) VALUES (:serviceId, :mediaURL)");

        foreach ($this->images as $mediaURL) {
            $stmt->bindParam(":serviceId", $this->id);
            $stmt->bindParam(":mediaURL", $mediaURL);
            $stmt->execute();
        }
    }
}
