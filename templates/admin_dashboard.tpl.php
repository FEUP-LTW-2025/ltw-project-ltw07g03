<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/category.class.php');

function drawAdminDashboard(array $categories, Session $session): void
{ ?>
    <section class="category-dashboard">
        <h3>Create a new category</h3>
        <?php foreach ($categories as $cat): ?>
            <?php $encoded = urlencode($cat->getName()); ?>
            <a class="category-box" href="/pages/category.php?name=<?= $encoded ?>">
                <span class="category-icon"><?= htmlspecialchars($cat->getIcon()) ?></span>
                <span class="category-name"><?= htmlspecialchars($cat->getName()) ?></span>
            </a>
        <?php endforeach; ?>
        <form class="add-category-form" action="/actions/action_create_category.php" method="post">
            <input type="hidden" name="csrf_token" value="<?= $session->getCSRFToken() ?? '' ?>">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="New category name" required>
            <label for="icon">Icon (emoji)</label>
            <input type="text" name="icon" placeholder="Paste emoji here" required>
            <input type="submit" value="Create">
        </form>
    </section>
<?php } ?>
