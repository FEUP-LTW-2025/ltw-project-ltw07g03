<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/search.tpl.php');
require_once(__DIR__ . '/../templates/authentication.tpl.php');

$session = new Session();
$db = getDatabaseConnection();

drawHeader("Register", $db, $session);
drawRegisterForm($session);

?>
    <script src="/javascript/image_preview.js"></script>
<?php

drawFooter();
