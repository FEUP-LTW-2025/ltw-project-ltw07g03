<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once(__DIR__ . "/../model/user.class.php");
require_once(__DIR__ . "/../database/connection.db.php");

$db = getDatabaseConnection();
$response = null;

try {
    if (isset($_GET["id"])) {
        $idParam = $_GET["id"];

        if (filter_var($idParam, FILTER_VALIDATE_INT) && (int)$idParam > 0) {
            $userId = (int)$idParam;

            $stmt = $db->prepare("SELECT userId, name, username, email, isAdmin, profilePictureURL, status FROM User WHERE userId = :id");
            $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                $response = $userData;
            } else {
                http_response_code(404);
                $response = ["error" => "User not found", "id" => $userId];
            }
        } else {
            http_response_code(400);
            $response = ["error" => "Invalid ID format."];
        }
    } else {
        $stmt = $db->prepare("SELECT userId, name, username, email, isAdmin, profilePictureURL, status FROM User");
        $stmt->execute();
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = $usersData;

        if ($response === null) {
            $response = [];
        }
    }
} catch (PDOException $e) {
    http_response_code(500);
    $response = ["error" => "A database error occurred."];
} catch (Exception $e) {
    http_response_code(500);
    $response = ["error" => "An unexpected error occurred."];
}

echo json_encode($response);
