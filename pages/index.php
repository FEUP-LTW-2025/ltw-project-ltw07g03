<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once __DIR__ . '/../templates/common.tpl.php';
require_once __DIR__ . '/../templates/home.tpl.php';

$session = new Session();

drawHeader("Home", $session);
drawHomeHeading();
drawHomeSearch();

?>

<?php
$categories = [
    ['name' => 'Programming & Tech', 'icon' => '💻'],
    ['name' => 'Graphics and Design', 'icon' => '🎨'],
    ['name' => 'Digital Marketing', 'icon' => '📈'],
    ['name' => 'Video & Animation', 'icon' => '🎬'],
    ['name' => 'Music & Audio', 'icon' => '🎧'],
    ['name' => 'Business', 'icon' => '💼']
];
?>

<section class="section" id="categories">
    <div class="container">
        <h2 class="section-title">Explore Categories</h2>
        <div class="category-row">
            <?php foreach ($categories as $cat): ?>
                <?php $encoded = urlencode($cat['name']); ?>
                <a href="category.php?name=<?= $encoded ?>" class="category-card">
                    <?= $cat['icon'] ?> <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php drawFooter(); ?>
