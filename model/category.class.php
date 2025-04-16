<?php
declare(strict_types=1);

class Category
{
    private int $id;
    private string $name;
    private string $icon;

    public function __construct(int $id, string $name, string $icon)
    {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public static function getCategoryById(PDO $db, int $id): ?Category
    {
        $stmt = $db->prepare("SELECT * FROM ServiceCategory WHERE serviceCategoryId = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return new Category(intval($data['serviceCategoryId']), $data['name'], $data['icon']);
    }

    public static function getCategoryByName(PDO $db, string $name): ?Category
    {
        $stmt = $db->prepare("SELECT * FROM ServiceCategory WHERE name = ?");
        $stmt->execute([$name]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return new Category(intval($data['serviceCategoryId']), $data['name'], $data['icon']);
    }

    public static function getAllCategories(PDO $db): array
    {
        $stmt = $db->query("SELECT * FROM ServiceCategory");
        $categories = [];

        while ($row = $stmt->fetch()) {
            $categories[] = new Category(intval($row['serviceCategoryId']), $row['name'], $row['icon']);
        }

        return $categories;
    }

    public function upload(PDO $db): void
    {
        $stmt = $db->prepare("INSERT INTO ServiceCategory (name, icon) VALUES (:name, :icon)");

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":icon", $this->icon);

        $stmt->execute();
        $this->id = intval($db->lastInsertId());
    }
}
