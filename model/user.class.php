<?php
declare(strict_types=1);

class User
{
    private int $id;
    private string $name;
    private string $username;
    private string $email;
    private string $password;
    private bool $isAdmin;
    private string $profilePicture;
    private string $status;

    public function __construct(
        int    $id,
        string $name,
        string $username,
        string $email,
        string $password,
        bool   $isAdmin,
        string $profilePicture,
        string $status
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
        $this->profilePicture = $profilePicture;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getRating(PDO $db): float
    {
        $stmt = $db->prepare("SELECT AVG(S.rating) AS avg_rating FROM Service S WHERE S.freelancerId = :userId AND S.rating != 0");
        $stmt->bindParam(":userId", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        return round((float)$result['avg_rating'], 1);
    }

    public static function getUserByUsername(PDO $db, string $username): ?User
    {
        $stmt = $db->prepare("SELECT * FROM User WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $data = $stmt->fetch();

        if (!$data) {
            return Null;
        }
        return new User(
            intval($data['userId']),
            $data['name'],
            $data['username'],
            $data['email'],
            $data['password'],
            boolval($data['isAdmin']),
            $data['profilePictureURL'],
            $data['status'],
        );

    }

    public static function getUserByEmail(PDO $db, string $email): ?User
    {
        $stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $data = $stmt->fetch();

        if (!$data) {
            return Null;
        }
        return new User(
            intval($data['userId']),
            $data['name'],
            $data['username'],
            $data['email'],
            $data['password'],
            boolval($data['isAdmin']),
            $data['profilePictureURL'],
            $data['status'],
        );

    }

    public static function getUserById(PDO $db, int $id): ?User
    {
        $stmt = $db->prepare("SELECT * FROM User WHERE userId = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $data = $stmt->fetch();
        if (!$data) {
            return null;
        }
        return new User(
            intval($data['userId']),
            $data['name'],
            $data['username'],
            $data['email'],
            $data['password'],
            boolval($data['isAdmin']),
            $data['profilePictureURL'],
            $data['status']
        );
    }


    public function setName(string $name, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE User SET name = :name WHERE userId = :id");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->name = $name;
    }

    public function setUsername(string $username, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE User SET username = :username WHERE userId = :id");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->username = $username;
    }

    public function setEmail(string $email, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE User SET email = :email WHERE userId = :id");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->email = $email;
    }

    public function setPassword(string $password, PDO $db): void
    {
        $hashedPassword = sha1($password);
        $stmt = $db->prepare("UPDATE User SET password = :password WHERE userId = :id");
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->password = $hashedPassword;
    }

    public function setIsAdmin(bool $isAdmin, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE User SET isAdmin = :isAdmin WHERE userId = :id");
        $stmt->bindParam(":isAdmin", $isAdmin, PDO::PARAM_BOOL);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->isAdmin = boolval($isAdmin);
    }

    public function setProfilePicture(string $profilePicture, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE User SET profilePictureURL = :profilePicture WHERE userId = :id");
        $stmt->bindParam(":profilePicture", $profilePicture);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->profilePicture = $profilePicture;
    }

    public function setStatus(string $status, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE User SET status = :status WHERE userId = :id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->status = $status;
    }

    public function upload(PDO $db): void
    {
        $stmt = $db->prepare(
            "INSERT INTO User (name, username, email, password, isAdmin, profilePictureURL, status) 
        VALUES (:name, :username, :email, :password, :isAdmin, :profilePictureURL, :status)"
        );

        $isAdmin = intval($this->isAdmin);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":isAdmin", $isAdmin);
        $stmt->bindParam(":profilePictureURL", $this->profilePicture);
        $stmt->bindParam(":status", $this->status);

        $stmt->execute();
        $this->id = intval($db->lastInsertId());
    }
}
