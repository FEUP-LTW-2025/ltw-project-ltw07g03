<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/category.class.php');

function drawAdminDashboard(array $categories): void
{ ?>
    <section>
        <?php foreach ($categories as $cat): ?>
            <?php $encoded = urlencode($cat->getName()); ?>
            <a href="/pages/category.php?name=<?= $encoded ?>">
                <?= $cat->getIcon() ?> <?= $cat->getName() ?>
            </a>
        <?php endforeach; ?>
        <h2>Create a new category</h2>
        <form action="/actions/action_create_category.php" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="New category name">
            <label for="icon">Icon</label>
            <input type="text" name="icon" placeholder="New category icon">
            <input type="submit" value="Create">
        </form>
    </section>
<?php } ?>
