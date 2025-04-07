<?php
declare(strict_types=1);
?>

<?php function drawHomeHeading(): void
{ ?>
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
<?php } ?>

<?php function drawHomeSearch(): void
{ ?>
    <section class="search-section">
        <div class="container">
            <h2 class="section-title">What service are you looking for?</h2>
            <form action="/pages/search.php" method="GET" class="search-form">
                <label>
                    <input
                            type="text"
                            name="query"
                            placeholder="Try 'logo design', 'web developer'..."
                            class="search-input"
                            required
                    />
                </label>
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>
    </section>
<?php } ?>

<?php function drawHomeCategories(array $categories): void
{ ?>
    <section class="section" id="categories">
        <div class="container">
            <h2 class="section-title">Explore Categories</h2>
            <div class="category-row">
                <?php foreach ($categories as $cat): ?>
                    <?php $encoded = urlencode($cat['name']); ?>
                    <a href="/pages/category.php?name=<?= $encoded ?>" class="category-card">
                        <?= $cat['icon'] ?> <?= htmlspecialchars($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php } ?>
