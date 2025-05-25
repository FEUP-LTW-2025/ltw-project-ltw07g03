<?php

declare(strict_types=1);

require_once(__DIR__ . '/../model/feedback.class.php');

function drawPurchaseHistory(array $purchasesWithDetails, PDO $db): void
{ ?>
    <section class="user-services-section">
        <div class="category-container">
            <h2 class="section-title">Your Purchases</h2>
            <div class="service-grid">
                <?php if (!empty($purchasesWithDetails)): ?>
                    <?php foreach ($purchasesWithDetails as $item): ?>
                        <article class="service-display card-hover-lift">

                            <div class="service-slider" data-service-id="<?= $item['purchase']->getId() ?>">
                                <?php if (count($item['service']['images']) > 1): ?>
                                    <button class="slider-prev">‹</button>
                                <?php endif; ?>

                                <div class="slider-images">
                                    <?php foreach ($item['service']['images'] as $index => $imgURL): ?>
                                        <img src="<?= htmlspecialchars($imgURL) ?>"
                                            alt="Service image <?= $index + 1 ?>"
                                            class="slider-image<?= $index === 0 ? ' active' : '' ?>">
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($item['service']['images']) > 1): ?>
                                    <button class="slider-next">›</button>
                                <?php endif; ?>
                            </div>
                            <div class="service-info">
                                <h3 class="service-title"><?= htmlspecialchars($item['service']['title']) ?></h3>
                                <p class="service-price">€<?= number_format($item['service']['price']) ?></p>
                                <p class="freelancer-name text-ellipsis">
                                    Freelancer: <?= htmlspecialchars($item['service']['freelancer']['name']) ?></p>
                                <p class="service-delivery">
                                    Status: <?= htmlspecialchars($item['purchase']->getStatus()) ?></p>
                                <p class="status-description">
                                    Date: <?= gmdate("Y-m-d | H:i:s", $item['purchase']->getDate()) ?></p>
                                <?php if ($item['purchase']->getStatus() === 'closed' && !Feedback::feedbackExistsForPurchase($db, $item['purchase']->getId())): ?>
                                    <a href="review_form.php?purchase_id=<?= $item['purchase']->getId() ?>"
                                        class="btn-outline btn-transition">Leave a review</a>
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
