<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawCategoryResults(string $category, array $services): void
{ ?>
    <section class="section">
        <div class="container">
            <h2 class="section-title"><?php echo htmlspecialchars($category); ?> Services</h2>
            <div class="category-grid">
                <?php if (empty($selectedServices)): ?>
                    <p>No services found for this category.</p>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <div class="category-card"><?php echo htmlspecialchars($service); ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php } ?>
