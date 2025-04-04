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

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setServiceId(int $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }

    public function setDate(int $date): void
    {
        $this->date = $date;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
