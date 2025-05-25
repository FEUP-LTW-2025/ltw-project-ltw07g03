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
                echo '<h2 class="section-title">' . htmlspecialchars($category) . '</h2>';
            }
            ?>

            <div class="filter-controls">
                <div class="filter-dropdown">
                    <button class="filter-button" data-toggle-dropdown="#price-dropdown">
                        Price <span class="arrow">▼</span>
                    </button>
                    <div id="price-dropdown" class="dropdown-panel">
                        <h3>Price</h3>
                        <p class="range-label">Select range</p>
                        <div class="slider-container">
                            <div class="range-values">
                                <span>5€</span>
                                <span>500€</span>
                            </div>
                            <input type="range" id="slider-service-budget" min="5" max="500" value="250">
                        </div>
                        <div class="filter-actions">
                            <button class="clear-btn">Clear</button>
                            <button class="apply-btn">Apply</button>
                        </div>
                    </div>
                </div>
                <div class="filter-dropdown">
                    <button class="filter-button" data-toggle-dropdown="#rating-dropdown">
                        Rating <span class="arrow">▼</span>
                    </button>
                    <div id="rating-dropdown" class="dropdown-panel">
                        <h3>Rating</h3>
                        <p class="range-label">Select range</p>
                        <div class="slider-container">
                            <div class="range-values">
                                <span>0 ⭐</span>
                                <span>5 ⭐</span>
                            </div>
                            <input type="range" id="slider-service-rating" min="0" max="5" step="0.5" value="0">
                        </div>
                        <div class="filter-actions">
                            <button class="clear-btn">Clear</button>
                            <button class="apply-btn">Apply</button>
                        </div>
                    </div>
                </div>
                <div class="search-wrapper">
                    <?php
                    if (strtolower($category) === 'services') {
                    echo '<input type="text" id="search-service-input" class="search-bar" placeholder="Search services...">';
                    }
                    ?>
                </div>
            </div>
            <?php if (empty($services)): ?>
                <p>No services found in this category.</p>
            <?php else: ?>
                <div class="service-grid">
                    <?php foreach ($services as $service): ?>
                        <article class="service-display">
                            <div class="service-slider" data-service-id="<?= $service['serviceId'] ?>">
                                <?php if (count($service['images']) > 1): ?>
                                    <button class="slider-prev">‹</button>
                                <?php endif; ?>

                                <div class="slider-images">
                                    <?php foreach ($service['images'] as $index => $imgURL): ?>
                                        <a href="/pages/service_detail.php?id=<?= $service['serviceId'] ?>">
                                            <img src="<?= htmlspecialchars($imgURL) ?>"
                                                 alt="Service image <?= $index + 1 ?>"
                                                 class="slider-image slider-image-small<?= $index === 0 ? ' active' : '' ?>">
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
                                <p class="service-description"><?= htmlspecialchars($service['description']) ?></p>
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
