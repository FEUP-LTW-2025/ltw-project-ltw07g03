<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once(__DIR__ . "/../database/connection.db.php");

$db = getDatabaseConnection();
$response = null;

try {
    if (isset($_GET["id"])) {
        $idParam = $_GET["id"];

        if (filter_var($idParam, FILTER_VALIDATE_INT) && intval($idParam) > 0) {
            $serviceId = intval($idParam);

            $stmt = $db->prepare("SELECT freelancerId, categoryId, title, price, deliveryTime, description, status FROM Service WHERE serviceId = :id");
            $stmt->bindParam(":id", $serviceId, PDO::PARAM_INT);
            $stmt->execute();
            $serviceData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($serviceData) {
                $response = $serviceData;
            } else {
                http_response_code(404);
                $response = ["error" => "Service not found", "id" => $serviceId];
            }
        } else {
            http_response_code(400);
            $response = ["error" => "Invalid ID format."];
        }
    } else {
        $stmt = $db->prepare("SELECT freelancerId, categoryId, title, price, deliveryTime, description, status FROM Service");
        $stmt->execute();
        $servicesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = $servicesData;

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
