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
    private string $about;
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
        string $about,
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
        $this->about = $about;
        $this->status = $status;
        $this->rating = $rating;
        $this->images = $images;
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
            $data['about'],
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
                $data['about'],
                $data['status'],
                floatval($data['rating']),
                $images
            );
        }

        return $services;
    }

    public static function getAllServices(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM Service");
        $stmt->execute();

        $services = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $serviceId = intval($data['serviceId']);
            $freelancerId = intval($data['freelancerId']);
            $categoryId = intval($data['categoryId']);
            $title = $data['title'];
            $price = floatval($data['price']);
            $deliveryTime = intval($data['deliveryTime']);
            $description = $data['description'];
            $about = $data['about'];
            $status = $data['status'];
            $rating = floatval($data['rating']);

            $mediaStmt = $db->prepare("SELECT mediaURL FROM ServiceMedia WHERE serviceId = :id");
            $mediaStmt->bindParam(":id", $serviceId, PDO::PARAM_INT);
            $mediaStmt->execute();
            $images = $mediaStmt->fetchAll(PDO::FETCH_COLUMN);

            $services[] = new Service(
                $serviceId,
                $freelancerId,
                $categoryId,
                $title,
                $price,
                $deliveryTime,
                $description,
                $about,
                $status,
                $rating,
                $images
            );
        }

        return $services;
    }

    public static function getServicesBySearch(PDO $db, string $search, int $count, ?int $categoryId = null): array
    {
        $sql = 'SELECT * FROM Service WHERE title LIKE ? AND status = ?';
        $params = ["%$search%", 'active'];

        if ($categoryId) {
            $sql .= ' AND categoryId = ?';
            $params[] = $categoryId;
        }

        $sql .= ' LIMIT ?';
        $params[] = $count;

        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        $services = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $freelancerStmt = $db->prepare(
                'SELECT userId AS id, name, profilePictureURL FROM User WHERE userId = ?'
            );
            $freelancerStmt->execute([$row['freelancerId']]);
            $freelancer = $freelancerStmt->fetch(PDO::FETCH_ASSOC)
                ?: ['id' => 0, 'name' => 'Unknown', 'profilePictureURL' => '/assets/images/pfps/default.jpeg'];

            $mediaStmt = $db->prepare(
                'SELECT mediaURL FROM ServiceMedia WHERE serviceId = ?'
            );
            $mediaStmt->execute([$row['serviceId']]);
            $images = $mediaStmt->fetchAll(PDO::FETCH_COLUMN)
                ?: ['/assets/images/pfps/default.jpeg'];

            $services[] = [
                'serviceId' => intval($row['serviceId']),
                'title' => $row['title'],
                'description' => $row['description'],
                'price' => floatval($row['price']),
                'images' => $images,
                'avgRating' => floatval($row['rating']),
                'freelancer' => [
                    'id' => intval($freelancer['id']),
                    'name' => $freelancer['name'],
                    'profilePictureURL' => $freelancer['profilePictureURL']
                ]
            ];
        }

        return $services;
    }


    public static function getServicesByUserId(PDO $db, int $user_id): array
    {
        $stmt = $db->prepare("
        SELECT * FROM Service 
        WHERE freelancerId = :user_id AND status != 'deleted' ");

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $services = [];

        while ($row = $stmt->fetch()) {
            $serviceId = intval($row['serviceId']);

            $imageStmt = $db->prepare('SELECT mediaURL FROM ServiceMedia WHERE serviceId = :serviceId');
            $imageStmt->bindParam(':serviceId', $serviceId, PDO::PARAM_INT);
            $imageStmt->execute();
            $images = $imageStmt->fetchAll(PDO::FETCH_COLUMN);

            $services[] = new Service(
                $serviceId,
                intval($row['freelancerId']),
                isset($row['categoryId']) ? intval($row['categoryId']) : null,
                $row['title'],
                floatval($row['price']),
                intval($row['deliveryTime']),
                $row['description'],
                $row['about'],
                $row['status'],
                floatval($row['rating']),
                $images
            );
        }

        return $services;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFreelancerId(): int
    {
        return $this->freelancerId;
    }

    public function setFreelancerId(int $freelancerId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET freelancerId = :freelancerId WHERE serviceId = :id");
        $stmt->bindParam(":freelancerId", $freelancerId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->freelancerId = $freelancerId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET categoryId = :categoryId WHERE serviceId = :id");
        $stmt->bindParam(":categoryId", $categoryId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->categoryId = $categoryId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET title = :title WHERE serviceId = :id");
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->title = $title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET price = :price WHERE serviceId = :id");
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->price = $price;
    }

    public function getDeliveryTime(): int
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime(int $deliveryTime, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET deliveryTime = :deliveryTime WHERE serviceId = :id");
        $stmt->bindParam(":deliveryTime", $deliveryTime);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->deliveryTime = $deliveryTime;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET description = :description WHERE serviceId = :id");
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->description = $description;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function setAbout(string $about, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET about = :about WHERE serviceId = :id");
        $stmt->bindParam(":about", $about);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->about = $about;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET status = :status WHERE serviceId = :id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->status = $status;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Service SET rating = :rating WHERE serviceId = :id");
        $stmt->bindParam(":rating", $rating);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->rating = $rating;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): void
    {
        // TODO
        $this->images = $images;
    }

    public function upload(PDO $db): void
    {
        $stmt = $db->prepare(
            "INSERT INTO Service (freelancerId, categoryId, title, price, deliveryTime, description, about, status)
            VALUES (:freelancerId, :categoryId, :title, :price, :deliveryTime, :description, :about, :status)"
        );

        $stmt->bindParam(":freelancerId", $this->freelancerId);
        $stmt->bindParam(":categoryId", $this->categoryId);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":deliveryTime", $this->deliveryTime);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":about", $this->about);
        $stmt->bindParam(":status", $this->status);

        $stmt->execute();
        $this->id = intval($db->lastInsertId());

        $stmt = $db->prepare("INSERT INTO ServiceMedia (serviceId, mediaURL) VALUES (:serviceId, :mediaURL)");

        foreach ($this->images as $mediaURL) {
            $stmt->bindValue(":serviceId", $this->id, PDO::PARAM_INT);
            $stmt->bindValue(":mediaURL", $mediaURL, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
}
