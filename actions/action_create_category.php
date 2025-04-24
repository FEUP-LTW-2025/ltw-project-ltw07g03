<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../model/category.class.php');

$session = new Session();
$db = getDatabaseConnection();

$name = $_POST["name"];
$icon = $_POST["icon"];

$category = new Category(0, $name, $icon);
$category->upload($db);
header('Location: ' . $_SERVER['HTTP_REFERER']);
