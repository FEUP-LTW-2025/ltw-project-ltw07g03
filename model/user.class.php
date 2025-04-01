<?php
declare(strict_types=1);

class User
{
    public int $userId;
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    public bool $isAdmin;

    public function __construct(int $userId, string $name, string $username, string $email, string $password, bool $isAdmin)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

}