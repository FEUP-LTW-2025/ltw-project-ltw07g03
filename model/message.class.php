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

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    public function setReceiverId(int $receiverId): void
    {
        $this->receiverId = $receiverId;
    }

    public function setServiceId(int $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setDate(int $date): void
    {
        $this->date = $date;
    }
}
