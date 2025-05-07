<?php
declare(strict_types=1);

class Message
{
    private int $id;
    private int $senderId;
    private int $receiverId;
    private string $content;
    private int $date;

    public function __construct(int $id, int $senderId, int $receiverId, string $content, int $date)
    {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->content = $content;
        $this->date = $date;
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
            $data['content'],
            strtotime($data['date'])
        );
    }

    public static function getConversationUsersByUserId(PDO $db, int $userId): array
    {
        $stmt = $db->prepare("
            SELECT DISTINCT 
                CASE 
                    WHEN senderId = :userId THEN receiverId
                    ELSE senderId
                END AS other_user_id
            FROM Message
            WHERE senderId = :userId OR receiverId = :userId
        ");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => (int)$row['other_user_id'], $rows);
    }

    public static function getMessagesByParticipantsId(PDO $db, int $user1_id, int $user2_id): array
    {
        $stmt = $db->prepare("SELECT * FROM Message WHERE (senderId = :user1_id AND receiverId = :user2_id) OR (senderId = :user2_id AND receiverId = :user1_id) ORDER BY date ASC");

        $stmt->bindParam(':user1_id', $user1_id, PDO::PARAM_INT);
        $stmt->bindParam(':user2_id', $user2_id, PDO::PARAM_INT);
        $stmt->execute();

        $messagesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $messages = [];
        foreach ($messagesData as $data) {
            $messages[] = new Message(
                intval($data['messageId']),
                intval($data['senderId']),
                intval($data['receiverId']),
                $data['content'],
                is_numeric($data['date']) ? intval($data['date']) : strtotime($data['date']),
            );
        }

        return $messages;
    }

    public static function getMessagesSince(PDO $db, int $user1, int $user2, int $since): array
    {
        $stmt = $db->prepare("
            SELECT messageId, senderId, receiverId, content, date
            FROM Message
            WHERE (
        (senderId = :user1 AND receiverId = :user2) OR
        (senderId = :user2 AND receiverId = :user1)
    )
    AND CAST(date AS INTEGER) > :since
    ORDER BY CAST(date AS INTEGER) ASC
");
        $stmt->bindValue(':user1', $user1, PDO::PARAM_INT);
        $stmt->bindValue(':user2', $user2, PDO::PARAM_INT);
        $stmt->bindValue(':since', $since, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Message(
            (int)$row['messageId'],
            (int)$row['senderId'],
            (int)$row['receiverId'],
            $row['content'],
            (int)$row['date']
        ), $rows);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function setSenderId(int $senderId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Message SET senderId = :senderId WHERE messageId = :id");
        $stmt->bindParam(":senderId", $senderId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->senderId = $senderId;
    }

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function setReceiverId(int $receiverId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Message SET receiverId = :receiverId WHERE messageId = :id");
        $stmt->bindParam(":receiverId", $receiverId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->receiverId = $receiverId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Message SET content = :content WHERE messageId = :id");
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->content = $content;
    }

    public function getDate(): int
    {
        return $this->date;
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
            "INSERT INTO Message (senderId, receiverId, content, date) 
         VALUES (:senderId, :receiverId, :content, :date)"
        );


        $stmt->bindParam(":senderId", $this->senderId);
        $stmt->bindParam(":receiverId", $this->receiverId);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":date", $this->date);

        $stmt->execute();
    }
}
