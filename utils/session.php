<?php

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['id']);
    }

    public function logout()
    {
        session_destroy();
    }

    public function getId(): ?int
    {
        return $_SESSION['id'] ?? null;
    }

    public function getName(): ?string
    {
        return $_SESSION['name'] ?? null;
    }

    public function setId(int $id)
    {
        $_SESSION['id'] = $id;
    }

    public function setName(string $name)
    {
        $_SESSION['name'] = $name;
    }
}
