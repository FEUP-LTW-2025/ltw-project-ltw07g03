<?php
declare(strict_types=1);

class Message
{
    public int $messageId;
    public int $senderId;
    public int $receiverId;
    public int $serviceId;
    public string $content;
    public int $date;

    function __construct(int $messageId, int $senderId, int $receiverId, int $serviceId, string $content, int $date)
    {
        $this->messageId = $messageId;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->serviceId = $serviceId;
        $this->content = $content;
        $this->date = $date;
    }
}