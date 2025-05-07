<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/review_form.tpl.php');


$session = new Session();
$db = getDatabaseConnection();


$purchase_id = $_GET['purchase_id'];

drawHeader('Review Form', $db, $session);
drawReviewForm($purchase_id);
drawFooter();
?>