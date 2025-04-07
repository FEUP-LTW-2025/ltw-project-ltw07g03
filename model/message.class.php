<?php
declare(strict_types=1);

class Message
{
    private int $id;
    private int $senderId;
    private int $receiverId;
    private int $serviceId;
    private string $content;
    private int $date;

    public function __construct(int $id, int $senderId, int $receiverId, int $serviceId, string $content, int $date)
    {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->serviceId = $serviceId;
        $this->content = $content;
        $this->date = $date;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public static function getMessageById(PDO $db, int $id): ?Message
    {
        $stmt = $db->prepare("SELECT * FROM Message WHERE messageId = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }
        return new Message(
            intval($data['messageId']),
            intval($data['senderId']),
            intval($data['receiverId']),
            intval($data['serviceId']),
            $data['content'],
            strtotime($data['date'])
        );
    }


    public function setSenderId(int $senderId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Message SET senderId = :senderId WHERE messageId = :id");
        $stmt->bindParam(":senderId", $senderId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->senderId = $senderId;
    }

    public function setReceiverId(int $receiverId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Message SET receiverId = :receiverId WHERE messageId = :id");
        $stmt->bindParam(":receiverId", $receiverId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->receiverId = $receiverId;
    }

    public function setServiceId(int $serviceId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Message SET serviceId = :serviceId WHERE messageId = :id");
        $stmt->bindParam(":serviceId", $serviceId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->serviceId = $serviceId;
    }

    public function setContent(string $content, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Message SET content = :content WHERE messageId = :id");
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->content = $content;
    }

    public function setDate(int $date, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Message SET date = :date WHERE messageId = :id");
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->date = $date;
    }

    public function upload(PDO $db): void
    {
        $stmt = $db->prepare(
            "INSERT INTO Message (senderId, receiverId, serviceId, content, date) 
         VALUES (:senderId, :receiverId, :serviceId, :content, :date)"
        );

        $stmt->bindParam(":senderId", $this->senderId);
        $stmt->bindParam(":receiverId", $this->receiverId);
        $stmt->bindParam(":serviceId", $this->serviceId);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":date", $this->date);

        $stmt->execute();
    }
}
