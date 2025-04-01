<?php
declare(strict_types=1);

class Purchase
{
    public int $purchaseId;
    public int $serviceId;
    public int $clientId;
    public int $date;
    public string $status;

    function __construct(int $purchaseId, int $serviceId, int $clientId, int $date, string $status)
    {
        $this->purchaseId = $purchaseId;
        $this->serviceId = $serviceId;
        $this->clientId = $clientId;
        $this->date = $date;
        $this->status = $status;
    }
}