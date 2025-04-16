<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/search.tpl.php');
require_once(__DIR__ . '/../templates/authentication.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/category.class.php');
require_once(__DIR__ . '/../model/service.class.php');
?>

<?php function drawCategoryResults(string $category, array $services): void
{ ?>
    <section class="section">
        <div class="container">
            <h2 class="section-title"><?php echo htmlspecialchars($category); ?> Services</h2>
            <div class="category-grid">
                <?php if (empty($services)): ?>
                    <p>No services found for this category.</p>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <div class="category-card">
                        <h3><?= htmlspecialchars($service->getTitle()) ?></h3>
                        <p><strong>Price:</strong> <?= htmlspecialchars((string)$service->getPrice()) ?> €</p>
                        <p><?= htmlspecialchars($service->getDescription()) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php } ?>
