<?php
declare(strict_types=1);

class Message
{
    public int $id;
    public int $senderId;
    public int $receiverId;
    public int $serviceId;
    public string $content;
    public int $date;

    function __construct(int $id, int $senderId, int $receiverId, int $serviceId, string $content, int $date)
    {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->serviceId = $serviceId;
        $this->content = $content;
        $this->date = $date;
    }
}
