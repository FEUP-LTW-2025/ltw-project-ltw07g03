<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../model/purchase.class.php');

function drawServicesHistory(PDO $db, array $purchases): void
{ ?>
    <h3>Services You Have Sold</h3>
    <div class="services-history">
        <?php if (!empty($purchases)): ?>
            <?php foreach ($purchases as $purchase): ?>
                <?php
                $service = Service::getServiceById($db, $purchase['serviceId']);
                if (!$service) continue;
                ?>
                <div class="service-card">
                    <img src="<?= $service->getImages()[0]["mediaURL"] ?>" alt="Service Image" class="service-image">
                    <div class="service-info">
                        <p><strong>Title:</strong> <?= $service->getTitle() ?></p>
                        <p><strong>Price:</strong> €<?= number_format($service->getPrice(), 2) ?></p>
                        <p><strong>Status:</strong> <?= $purchase['status'] ?></p>
                        <p><strong>Date:</strong> <?= gmdate("Y-m-d | H:i:s", strtotime($purchase['date'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You haven't sold any services yet.</p>
        <?php endif; ?>
    </div>
<?php }
