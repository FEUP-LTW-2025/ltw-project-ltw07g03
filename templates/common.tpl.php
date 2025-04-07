<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader(string $title, Session $session) { ?>
    <!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= "FLEXA :: " . $title ?></title>
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>
<header class="site-header dark-header">
    <div class="container header-flex">
        <div class="logo">
            <img
                    src="/assets/images/flexa-logo@2x.png"
                    srcset="/assets/images/flexa-logo@2x.png 2x"
                    alt="FLEXA logo"
                    class="logo-img-big"
            />
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Login</a></li>
                <li><a href="#">Register</a></li>
            </ul>
        </nav>
    </div>
</header>
<main>
    <?php } ?>

    <?php function drawFooter() { ?>
</main>
<footer class="site-footer">
    <div class="container">
        <p>&copy; 2025 FLEXA. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
<?php } ?>
