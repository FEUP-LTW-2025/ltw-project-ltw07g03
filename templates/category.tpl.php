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
    <section class="category-section">
        <div class="category-container">
            <?php
            if (strtolower($category) === 'serviços') {
                echo '<h2 class="section-category-title">Services</h2>';
            } elseif (str_starts_with($category, '_')) {
                echo '<h2 class="section-category-title">Search Results for ' . htmlspecialchars(ucfirst(substr($category, 1))) . '</h2>';
            } else {
                echo '<h2 class="section-category-title">' . $category . '</h2>';
            }
            ?>
            <?php if (empty($services)): ?>
                <p>No services found in this category.</p>
            <?php else: ?>
                <div class="service-grid">
                    <?php foreach ($services as $service): ?>
                        <article class="service-display">
                            <img src="<?= htmlspecialchars($service['images'][0] ?? '/assets/images/pfps/default.jpeg') ?>"
                                 alt="Service image" class="service-image">

                            <div class="service-info">
                                <h3 class="service-title"><?= htmlspecialchars($service['title']) ?></h3>
                                <p class="service-price"><?= htmlspecialchars((string)$service['price']) ?> €</p>
                                <p class="service-description"><?= htmlspecialchars($service['description']) ?></p>
                                <div class="freelancer-info">
                                    <img src="<?= htmlspecialchars($service['freelancer']['profilePictureURL']) ?>"
                                         alt="Freelancer profile" class="freelancer-pic">
                                    <span class="freelancer-name"><?= htmlspecialchars($service['freelancer']['name']) ?></span>
                                </div>
                                <?php if ($service['avgRating'] != 0): ?>
                                    <p class="service-rating">⭐ <?= htmlspecialchars((string)$service['avgRating']) ?>
                                        / 5</p>
                                <?php else: ?>
                                    <p class="service-rating">⭐ No ratings yet</p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php } ?>
