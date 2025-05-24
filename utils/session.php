<?php

class Session
{
    private array $messages;

    public function __construct()
    {
        session_start();
        $this->generateCSRFToken();
    }

    public function generateCSRFToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
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

    public function addMessage(string $type, string $text)
    {
        $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages()
    {
        return $_SESSION['messages'];
    }

    public function validateCSRFToken(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public function getCSRFToken(): ?string
    {
        return $_SESSION['csrf_token'] ?? null;
    }
}
