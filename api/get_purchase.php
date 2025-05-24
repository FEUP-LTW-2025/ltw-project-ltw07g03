<?php
declare(strict_types=1);
require_once(__DIR__ . "/../database/connection.db.php");

header('Content-Type: application/json');

$db = getDatabaseConnection();
$response = null;

try {
    if (isset($_GET["id"])) {
        $idParam = $_GET["id"];

        if (filter_var($idParam, FILTER_VALIDATE_INT) && intval($idParam) > 0) {
            $purchaseId = intval($idParam);

            $stmt = $db->prepare("SELECT purchaseId, serviceId, clientId, strftime('%Y-%m-%d %H:%M:%S', date, 'unixepoch') AS date, status FROM Purchase WHERE purchaseId = :id");
            $stmt->bindParam(":id", $purchaseId, PDO::PARAM_INT);
            $stmt->execute();
            $purchaseData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($purchaseData) {
                $response = $purchaseData;
            } else {
                http_response_code(404);
                $response = ["error" => "Purchase not found", "id" => $purchaseId];
            }
        } else {
            http_response_code(400);
            $response = ["error" => "Invalid ID format."];
        }
    } else {
        $stmt = $db->prepare("SELECT purchaseId, serviceId, clientId, strftime('%Y-%m-%d %H:%M:%S', date, 'unixepoch') AS date, status FROM Purchase");
        $stmt->execute();
        $purchasesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = $purchasesData;

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
