<?php
declare(strict_types=1);
require_once(__DIR__ . '/session.php');
require_once(__DIR__ . '/security.php');

function handleSingleImageUpload(
    array   $file,
    string  $uploadDir,
    string  $uploadUrl,
    string  $defaultUrl,
    Session $session,
    array   $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
    int     $maxSize = 5242880
): string
{
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return $defaultUrl;
    }

    if (!Security::validateFileUpload($file, $allowedTypes, $maxSize)) {
        $session->addMessage('error', 'Invalid image. Only images under 5MB are allowed.');
        return $defaultUrl;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $actualMimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($actualMimeType, $allowedTypes, true)) {
        $session->addMessage('error', 'File type validation failed.');
        return $defaultUrl;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $allowedExtensions)) {
        $session->addMessage('error', 'Invalid file extension.');
        return $defaultUrl;
    }

    $name = Security::generateSecureFilename($file['name']);
    $dest = $uploadDir . $name;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        chmod($dest, 0644);
        return $uploadUrl . $name;
    }

    $session->addMessage('error', 'Could not save uploaded image.');
    return $defaultUrl;
}
