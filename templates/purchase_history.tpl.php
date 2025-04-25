<?php
declare(strict_types=1);

function drawPurchaseHistory(array $purchasesWithDetails): void
{ ?>
    <div>
        <h3>Your Purchases</h3>
        <?php if (!empty($purchasesWithDetails)): ?>
            <?php foreach ($purchasesWithDetails as $item): ?>
                <div class="purchase-card">
                    <p><strong>Service:</strong> <?= $item['service']['title'] ?></p>
                    <p><strong>Freelancer:</strong> <?= $item['service']['freelancer']['name'] ?></p>
                    <p><strong>Status:</strong> <?= $item['purchase']->getStatus() ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You haven't made any purchases yet.</p>
        <?php endif; ?>
    </div>
<?php } ?>

