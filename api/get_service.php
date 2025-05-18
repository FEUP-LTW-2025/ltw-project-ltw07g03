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

            $stmt = $db->prepare("
                SELECT s.serviceId, s.freelancerId, sc.name AS category, s.title, s.price, 
                       s.deliveryTime, s.description, s.about, s.status, s.rating 
                FROM Service s
                JOIN ServiceCategory sc ON (s.categoryId = sc.serviceCategoryId) 
                WHERE s.serviceId = :id
            ");
            $stmt->bindParam(":id", $serviceId, PDO::PARAM_INT);
            $stmt->execute();
            $serviceData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($serviceData) {
                $mediaStmt = $db->prepare("SELECT mediaURL FROM ServiceMedia WHERE serviceId = :serviceId");
                $mediaStmt->bindParam(":serviceId", $serviceId, PDO::PARAM_INT);
                $mediaStmt->execute();
                $mediaUrls = $mediaStmt->fetchAll(PDO::FETCH_COLUMN);

                $serviceData['media'] = $mediaUrls ?: [];
                $response = $serviceData;

            } else {
                http_response_code(404);
                $response = ["error" => "Service not found", "id" => $serviceId];
            }
        } else {
            http_response_code(400);
            $response = ["error" => "Invalid ID format. ID must be a positive integer."];
        }
    } else {
        $stmt = $db->prepare("
            SELECT s.serviceId, s.freelancerId, sc.name AS category, s.title, s.price, 
                   s.deliveryTime, s.description, s.about, s.status, s.rating 
            FROM Service s
            JOIN ServiceCategory sc ON (s.categoryId = sc.serviceCategoryId)
        ");
        $stmt->execute();
        $servicesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($servicesData) {
            $serviceIds = array_map(function ($service) {
                return $service['serviceId'];
            }, $servicesData);

            if (!empty($serviceIds)) {
                $placeholders = implode(',', array_fill(0, count($serviceIds), '?'));

                $mediaStmt = $db->prepare("SELECT serviceId, mediaURL FROM ServiceMedia WHERE serviceId IN ($placeholders)");
                foreach ($serviceIds as $k => $id) {
                    $mediaStmt->bindValue(($k + 1), $id, PDO::PARAM_INT);
                }
                $mediaStmt->execute();
                $allMedia = $mediaStmt->fetchAll(PDO::FETCH_ASSOC);

                $mediaByServiceId = [];
                foreach ($allMedia as $media) {
                    $mediaByServiceId[$media['serviceId']][] = $media['mediaURL'];
                }

                foreach ($servicesData as &$service) {
                    $service['media'] = $mediaByServiceId[$service['serviceId']] ?? [];
                }
            } else {
                foreach ($servicesData as &$service) {
                    $service['media'] = [];
                }
            }
            unset($service);
        }
        $response = $servicesData ?: [];
    }
} catch (PDOException $e) {
    http_response_code(500);
    $response = ["error" => "A database error occurred."];
    error_log("Database Error: " . $e->getMessage());
} catch (Exception $e) {
    http_response_code(500);
    $response = ["error" => "An unexpected error occurred."];
    error_log("Unexpected Error: " . $e->getMessage());
}

echo json_encode($response);