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

<?php function drawCategoryResults(string $category, array $services): void { ?>
  <section class="category-section">
    <div class="category-container">
      <h2 class="section-category-title"><?= htmlspecialchars($category) ?> Services</h2>

      <?php if (empty($services)): ?>
        <p>No services found in this category.</p>
      <?php else: ?>
        <div class="service-grid">
          <?php foreach ($services as $service): ?>
            <article class="service-display">
              <img src="<?= htmlspecialchars($service->getImages()[0] ?? 'default.jpg') ?>" alt="Service image" class="service-image">

              <div class="service-info">
                <h3 class="service-title"><?= htmlspecialchars($service->getTitle()) ?></h3>
                <p class="service-price"><?= htmlspecialchars((string)$service->getPrice()) ?> €</p>
                <p class="service-description"><?= htmlspecialchars($service->getDescription()) ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php } ?>
