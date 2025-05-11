<?php
declare(strict_types=1);

function drawPurchaseHistory(array $purchasesWithDetails): void
{ ?>
    <section class="user-services-section">
        <div class="category-container">
            <h2 class="section-title">Your Purchases</h2>
            <div class="service-grid">
                <?php if (!empty($purchasesWithDetails)): ?>
                    <?php foreach ($purchasesWithDetails as $item): ?>
                        <article class="service-display">
                            <img src="<?= htmlspecialchars($item["service"]["images"][0]) ?>" alt="Service Image" class="service-image">
                            <div class="service-info">
                                <h3 class="service-title"><?= htmlspecialchars($item['service']['title']) ?></h3>
                                <p class="service-price">€<?= number_format($item['service']['price']) ?></p>
                                <p class="freelancer-name">Freelancer: <?= htmlspecialchars($item['service']['freelancer']['name']) ?></p>
                                <p class="service-delivery">Status: <?= htmlspecialchars($item['purchase']->getStatus()) ?></p>
                                <p class="status-description">Date: <?= gmdate("Y-m-d | H:i:s", $item['purchase']->getDate()) ?></p>

                                <?php 
                                    if($item['purchase']->getStatus() === 'closed'): ?>
                                    <a href="review_form.php?purchase_id=<?= $item['purchase']->getId() ?>" class="btn-outline">Leave a review</a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="user-services-empty">You haven't made any purchases yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php } ?>

