<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../model/user.class.php');

function drawHeader(string $title, PDO $db, Session $session): void
{ ?>
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
            <a href="/pages/index.php">
                <img
                        src="/assets/images/flexa-logo@2x.png"
                        srcset="/assets/images/flexa-logo@2x.png 2x"
                        alt="FLEXA logo"
                        class="logo-img-big"
                />
            </a>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="/pages/services.php">Services</a></li>
                <?php
                if ($session->isLoggedIn()) {
                    echo '<li><a href="/pages/user.php?id=' . $session->getId() . '">Profile</a></li>';
                    echo '<li><a href="/actions/action_logout.php">Logout</a></li>';
                    $user = User::getUserById($db, $session->getId());
                    if ($user->isAdmin()) {
                        echo '<li><a href="/pages/admin_dashboard.php">Admin Dashboard</a></li>';
                    }
                } else {
                    echo '<li><a href="/pages/login.php">Login</a></li>';
                    echo '<li><a href="/pages/signup.php">Register</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</header>
<main>
    <?php } ?>

    <?php function drawFooter(): void
    { ?>
</main>
<footer class="site-footer">
    <div class="container">
        <p>&copy 2025 FLEXA. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
<?php } ?>
