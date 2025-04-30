<?php
declare(strict_types=1);

function drawPurchaseHistory(array $purchasesWithDetails): void
{ ?>
    <h3>Your Purchases</h3>
    <div>
        <?php if (!empty($purchasesWithDetails)): ?>
            <?php foreach ($purchasesWithDetails as $item): ?>
                <div class="purchase-card">
                    <img src="<?= $item["service"]["images"][0] ?>">
                    <p><strong>Service:</strong> <?= $item['service']['title'] ?></p>
                    <p><strong>Freelancer:</strong> <?= $item['service']['freelancer']['name'] ?></p>
                    <p><strong>Status:</strong> <?= $item['purchase']->getStatus() ?></p>
                    <p><strong>Date:</strong> <?= gmdate("Y-m-d | H:i:s", $item['purchase']->getDate()) ?></p>

                    <?php
                        if($item['purchase']->getStatus() === 'closed'){
                            echo '<a href="review_form.php?purchase_id=' .$item['purchase']->getId() . '" class="review-button">Leave a review</a>';
                        }
                    ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You haven't made any purchases yet.</p>
        <?php endif; ?>
    </div>
<?php } ?>

