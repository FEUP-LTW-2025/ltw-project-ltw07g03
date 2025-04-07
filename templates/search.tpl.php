<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawSearchResults(string $search, array $results)
{ ?>
    <section class="section">
        <div class="container">
            <h2 class="section-title">Search Results for: <?= htmlspecialchars($search) ?></h2>

            <?php if (!empty($results)): ?>
                <ul class="category-grid">
                    <?php foreach ($results as $result): ?>
                        <li class="category-card"><?= htmlspecialchars($result) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No services found.</p>
            <?php endif; ?>
        </div>
    </section>
<?php } ?>
