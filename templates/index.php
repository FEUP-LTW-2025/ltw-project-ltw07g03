<?php declare(strict_types = 1); ?>
<?php require_once 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Freelance Platform</title>
  <link rel="stylesheet" href="../css/style.css"/>
</head>
<body>

<!-- Hero section with background image and main heading -->

<section class="hero hero-with-bg">
  <div class="hero-overlay">
    <div class="container hero-grid">
      <div class="hero-text">
        <h1 class="hero-title">Freelancing made simple with <span class="highlight">FLEXA</span></h1>
        <p class="hero-subtitle">Hire top talent or get hired - all in one place.</p>
        <a href="#categories" class="hero-btn">GET STARTED</a>
      </div>
    </div>
  </div>
</section>

<!-- Search section -->

<section class="search-section">
  <div class="container">
    <h2 class="section-title">What service are you looking for?</h2>
    <form action="search.php" method="GET" class="search-form">
      <input
        type="text"
        name="query"
        placeholder="Try 'logo design', 'web developer'..."
        class="search-input"
        required
      />
      <button type="submit" class="search-btn">Search</button>
    </form>
  </div>
</section>

<?php 

// categories definition 

$categories = [
  ['name' => 'Programming & Tech', 'icon' => '💻'],
  ['name' => 'Graphics and Design', 'icon' => '🎨'],
  ['name' => 'Digital Marketing', 'icon' => '📈'],
  ['name' => 'Video & Animation', 'icon' => '🎬'],
  ['name' => 'Music & Audio', 'icon' => '🎧'],
  ['name' => 'Business', 'icon' => '💼']
];
?>

<!-- Horizontal scrolling categories -->

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

<?php require_once 'includes/footer.php'; ?>
</body>
</html>


