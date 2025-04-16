<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');

function getServices_FreelancersByCategoryId(PDO $db, int $cat_id): array
{
    $stmt = $db->prepare("
         SELECT 
            S.serviceId,
            S.title,
            S.price,
            S.deliveryTime,
            S.description,
            S.status,
            U.name AS freelancerName,
            U.profilePictureURL,
            SM.mediaURL,
            (
                SELECT AVG(F.rating)
                FROM Purchase P
                JOIN Feedback F ON P.purchaseId = F.purchaseId
                WHERE P.serviceId = S.serviceId
            ) AS avgRating
        FROM Service S
        JOIN User U ON S.freelancerId = U.userId
        JOIN ServiceMedia SM ON S.serviceId = SM.serviceId
        WHERE S.categoryId = :cat_id
    ");

    $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
    $stmt->execute();

    $services = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['serviceId'];

        if (!isset($services[$id])) {
            $services[$id] = [
                'title' => $row['title'],
                'price' => $row['price'],
                'deliveryTime' => $row['deliveryTime'],
                'description' => $row['description'],
                'status' => $row['status'],
                'avgRating' => round((float)$row['avgRating'], 1),
                'freelancer' => [
                    'name' => $row['freelancerName'],
                    'profilePictureURL' => $row['profilePictureURL']
                ],
                'images' => []
            ];
        }

        $services[$id]['images'][] = $row['mediaURL'];
    }

    return array_values($services);
}

function getFreelancersForServices(PDO $db, array $services): array
{

    $serviceIds = [];
    foreach ($services as $service) {
        $serviceIds[] = $service->getId();
    }

    if (empty($serviceIds)) {
        return [];
    }

    $placeholders = implode(',', array_fill(0, count($serviceIds), '?'));

    $stmt = $db->prepare("
        SELECT 
            S.serviceId,
            S.title,
            S.price,
            S.deliveryTime,
            S.description,
            S.status,
            U.name AS freelancerName,
            U.profilePictureURL,
            SM.mediaURL,
            (
                SELECT AVG(F.rating)
                FROM Purchase P
                JOIN Feedback F ON P.purchaseId = F.purchaseId
                WHERE P.serviceId = S.serviceId
            ) AS avgRating
        FROM Service S
        JOIN User U ON S.freelancerId = U.userId
        JOIN ServiceMedia SM ON S.serviceId = SM.serviceId
        WHERE S.serviceId IN ($placeholders)  
    ");

    foreach ($serviceIds as $index => $id) {
        $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
    }

    $stmt->execute();


    $servicesWithDetails = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['serviceId'];

        if (!isset($servicesWithDetails[$id])) {
            $servicesWithDetails[$id] = [
                'title' => $row['title'],
                'price' => $row['price'],
                'deliveryTime' => $row['deliveryTime'],
                'description' => $row['description'],
                'status' => $row['status'],
                'avgRating' => round((float)$row['avgRating'], 1),
                'freelancer' => [
                    'name' => $row['freelancerName'],
                    'profilePictureURL' => $row['profilePictureURL']
                ],
                'images' => []
            ];
        }

        $servicesWithDetails[$id]['images'][] = $row['mediaURL'];
    }

    return array_values($servicesWithDetails);
}
