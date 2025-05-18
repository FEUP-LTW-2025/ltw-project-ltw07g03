<?php
declare(strict_types=1);

require_once(__DIR__ . '/session.php');

function handleSingleImageUpload(
    array   $file,
    string  $uploadDir,
    string  $uploadUrl,
    string  $defaultUrl,
    Session $session,
    array   $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']
): string
{
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return $defaultUrl;
    }

    if (!in_array($file['type'], $allowedTypes, true)) {
        $session->addMessage('error', 'Invalid image type. Allowed: jpg, png, gif');
        return $defaultUrl;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $name = uniqid('img_', true) . '.' . $ext;
    $dest = $uploadDir . $name;
    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return $uploadUrl . $name;
    }

    $session->addMessage('error', 'Could not save uploaded image.');
    return $defaultUrl;
}

