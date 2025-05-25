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
            if (strtolower($category) === 'services') {
                echo '<h2 class="section-title">Services</h2>';
            } elseif (str_starts_with($category, '_')) {
                echo '<h2 class="section-title">Search Results for ' . htmlspecialchars(ucfirst(substr($category, 1))) . '</h2>';
            } else {

                echo '<h2 class="section-category-title">' . htmlspecialchars($category) . '</h2>';
            }
            ?>

            <?php if (empty($services)): ?>
                <p>No services found in this category.</p>
            <?php else: ?>
                <div class="service-grid">
                    <?php foreach ($services as $service): ?>
                        <article class="service-display card-hover-lift">
                            <div class="service-slider" data-service-id="<?= $service['serviceId'] ?>">
                                <?php if (count($service['images']) > 1): ?>
                                    <button class="slider-prev">‹</button>
                                <?php endif; ?>

                                <div class="slider-images">
                                    <?php foreach ($service['images'] as $index => $imgURL): ?>
                                        <a href="/pages/service_detail.php?id=<?= $service['serviceId'] ?>">
                                            <img src="<?= htmlspecialchars($imgURL) ?>"
                                                alt="Service image <?= $index + 1 ?>"
                                                class="slider-image<?= $index === 0 ? ' active' : '' ?>">
                                        </a>
                                    <?php endforeach; ?>
                                </div>

                                <?php if (count($service['images']) > 1): ?>
                                    <button class="slider-next">›</button>
                                <?php endif; ?>
                            </div>

                            <div class="service-info">
                                <h3 class="service-title"><?= htmlspecialchars($service['title']) ?></h3>
                                <p class="service-price"><?= htmlspecialchars((string)$service['price']) ?> €</p>
                                <p class="service-description text-clamp-3"><?= htmlspecialchars($service['description']) ?></p>
                                <div class="freelancer-info">
                                    <a href="/pages/user.php?id=<?= $service['freelancer']['id'] ?>">
                                        <img src="<?= htmlspecialchars($service['freelancer']['profilePictureURL']) ?>"
                                            alt="Freelancer profile" class="freelancer-pic">
                                        <span class="freelancer-name"><?= htmlspecialchars($service['freelancer']['name']) ?></span>
                                    </a>
                                </div>
                                <?php if ($service['avgRating'] != 0): ?>
                                    <p class="service-rating">⭐ <?= htmlspecialchars((string)$service['avgRating']) ?> /
                                        5</p>
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
