<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/service.class.php');
require_once(__DIR__ . '/../model/purchase.class.php');

function drawServicesHistory(PDO $db, array $purchases, Session $session): void
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
                            <div class="service-slider" data-service-id="<?= $purchase['purchaseId'] ?>">
                                <?php if (count($service->getImages()) > 1): ?>
                                    <button class="slider-prev">‹</button>
                                <?php endif; ?>
                                <div class="slider-images">
                                    <?php foreach ($service->getImages() as $index => $img): ?>
                                        <img src="<?= htmlspecialchars($img['mediaURL']) ?>"
                                            alt="Service image <?= $index + 1 ?>"
                                            class="slider-image<?= $index === 0 ? ' active' : '' ?>">
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($service->getImages()) > 1): ?>
                                    <button class="slider-next">›</button>
                                <?php endif; ?>
                            </div>
                            <div class="service-info">
                                <h3 class="service-title"><?= htmlspecialchars($service->getTitle()) ?></h3>
                                <p class="service-price">€<?= number_format($service->getPrice()) ?></p>
                                <p class="service-delivery">Status: <?= htmlspecialchars($purchase['status']) ?></p>
                                <p class="status-description">Date: <?= gmdate("Y-m-d | H:i:s", $purchase['date']) ?></p>

                                <?php if ($purchase['status'] === 'pending'): ?>
                                    <button
                                        class="btn-outline close-purchase-btn"
                                        data-purchase-id="<?= $purchase['purchaseId'] ?>"
                                        data-freelancer-id="<?= $service->getFreelancerId() ?>"
                                        data-csrf-token="<?= $session->getCSRFToken() ?? '' ?>">
                                        Mark as closed
                                    </button>
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
