<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../model/purchase.class.php');

function drawServicesHistory(PDO $db, array $purchases): void
{ ?>
    <section class="user-services-section"> 
        <div class="category-container">
            <h2 class="section-title">Sold Services</h2>
            <div class="service-grid">
                <?php if (!empty($purchases)): ?>
                    <?php foreach ($purchases as $purchase): ?>
                        <?php
                        $service = Service::getServiceById($db, $purchase['serviceId']);
                        if (!$service) continue;
                        ?>
                        <article class="service-display">
                            <img src="<?= htmlspecialchars($service->getImages()[0]["mediaURL"]) ?>" alt="Service Image" class="service-image">
                        
                            <div class="service-info">
                                <h3 class="service-title"><?= htmlspecialchars($service->getTitle()) ?></h3>
                                <p class="service-price">€<?= number_format($service->getPrice()) ?></p>
                                <p class="service-delivery">Status: <?= htmlspecialchars($purchase['status']) ?></p>
                                <p class="status-description">Date: <?= gmdate("Y-m-d | H:i:s", $purchase['date']) ?></p>

                                <?php if ($purchase['status'] === 'pending'): ?>
                                    <form method="post" action="/actions/action_close_purchase.php">
                                        <input type="hidden" name="purchaseId" value="<?= $purchase['purchaseId'] ?>">
                                        <input type="hidden" name="freelancerId" value="<?= $service->getFreelancerId() ?>">
                                        <button type="submit" class="btn-outline">Mark as closed</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="user-services-empty">You haven't sold any services yet.</p>
                <?php endif; ?>   
            </div>
        </div>
    </section>
<?php } ?>
