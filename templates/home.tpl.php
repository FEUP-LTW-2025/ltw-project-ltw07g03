<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHomeHeading()
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

<?php function drawHomeSearch()
{ ?>
    <section class="search-section">
        <div class="container">
            <h2 class="section-title">What service are you looking for?</h2>
            <form action="../templates/search.php" method="GET" class="search-form">
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
<?php } ?>