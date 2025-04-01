<?php
declare(strict_types=1);

class User
{
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    public bool $isAdmin;
    public string $profilePicture;
    public string $status;

    public function __construct(int $id, string $name, string $username, string $email, string $password, bool $isAdmin, string $profilePicture, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
        $this->profilePicture = $profilePicture;
        $this->status = $status;
    }
}
