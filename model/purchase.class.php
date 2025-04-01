<?php
declare(strict_types=1);

class Purchase
{
    public int $id;
    public int $serviceId;
    public int $clientId;
    public int $date;
    public string $status;

    function __construct(int $id, int $serviceId, int $clientId, int $date, string $status)
    {
        $this->id = $id;
        $this->serviceId = $serviceId;
        $this->clientId = $clientId;
        $this->date = $date;
        $this->status = $status;
    }
}
