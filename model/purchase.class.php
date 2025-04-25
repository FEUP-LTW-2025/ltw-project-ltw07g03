<?php
declare(strict_types=1);

class Purchase
{
    private int $id;
    private int $serviceId;
    private int $clientId;
    private int $date;
    private string $status;

    public function __construct(int $id, int $serviceId, int $clientId, int $date, string $status)
    {
        $this->id = $id;
        $this->serviceId = $serviceId;
        $this->clientId = $clientId;
        $this->date = $date;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public static function getPurchaseById(PDO $db, int $id): ?Purchase
    {
        $stmt = $db->prepare("SELECT * FROM Purchase WHERE purchaseId = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }
        return new Purchase(
            intval($data['purchaseId']),
            intval($data['serviceId']),
            intval($data['clientId']),
            strtotime($data['date']),
            $data['status']
        );
    }

    public static function getPurchaseByClientId(PDO $db, int $client_id): ?array
    {
        $purchases = [];

        $stmt = $db->prepare("SELECT * FROM Purchase WHERE clientId = :client_id");
        $stmt->bindParam(":client_id", $client_id, PDO::PARAM_INT);
        $stmt->execute();
        
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $purchases[] = new Purchase(
                intval($data['purchaseId']),
                intval($data['serviceId']),
                intval($data['clientId']),
                strtotime($data['date']),
                $data['status']
            );
        }

        return $purchases;
    }


    public function setServiceId(int $serviceId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Purchase SET serviceId = :serviceId WHERE purchaseId = :id");
        $stmt->bindParam(":serviceId", $serviceId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->serviceId = $serviceId;
    }

    public function setClientId(int $clientId, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Purchase SET clientId = :clientId WHERE purchaseId = :id");
        $stmt->bindParam(":clientId", $clientId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->clientId = $clientId;
    }

    public function setDate(int $date, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Purchase SET date = :date WHERE purchaseId = :id");
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->date = $date;
    }

    public function setStatus(string $status, PDO $db): void
    {
        $stmt = $db->prepare("UPDATE Purchase SET status = :status WHERE purchaseId = :id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->status = $status;
    }

    public function upload(PDO $db): void
    {
        $stmt = $db->prepare(
            "INSERT INTO Purchase (serviceId, clientId, date, status) 
         VALUES (:serviceId, :clientId, :date, :status)"
        );

        $stmt->bindParam(":serviceId", $this->serviceId);
        $stmt->bindParam(":clientId", $this->clientId);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":status", $this->status);

        $stmt->execute();
    }
}
