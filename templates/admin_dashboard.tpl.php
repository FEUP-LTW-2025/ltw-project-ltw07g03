<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/category.class.php');

function drawAdminDashboard(array $categories): void
{ ?>
    <section class="category-dashboard">
        <h3>Create a new category</h3>
        <?php foreach ($categories as $cat): ?>
            <?php $encoded = $cat->getName(); ?>
            <a class="category-box" href="/pages/category.php?name=<?= $encoded ?>">
                <span class="category-icon"><?= $cat->getIcon() ?></span>
                <span class="category-name"><?= $cat->getName() ?></span>
            </a>
        <?php endforeach; ?>
        <form class="add-category-form" action="/actions/action_create_category.php" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="New category name" required>
            <label for="icon">Icon (emoji)</label>
            <input type="text" name="icon" placeholder="Paste emoji here" required>
            <input type="submit" value="Create">
        </form>
    </section>
<?php } ?>
