<?php
declare(strict_types=1);
require_once(__DIR__ . '/session.php');

class Security
{
    public static function validateCSRFToken(Session $session): bool
    {
        if (!isset($_POST['csrf_token'])) {
            return false;
        }

        return $session->validateCSRFToken($_POST['csrf_token']);
    }

    public static function sanitizeInput(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword(string $password): bool
    {
        return strlen($password) >= 8 &&
            preg_match('/[A-Za-z]/', $password) &&
            preg_match('/[0-9]/', $password);
    }

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 65536,
            'time_cost' => 4,
            'threads' => 3,
        ]);
    }

    public static function generateSecureFilename(string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $randomName = bin2hex(random_bytes(16));
        return $randomName . '.' . $extension;
    }

    public static function validateFileUpload(array $file, array $allowedTypes, int $maxSize): bool
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return false;
        }

        return true;
    }
}
