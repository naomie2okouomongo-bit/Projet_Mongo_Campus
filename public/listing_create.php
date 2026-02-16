<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/auth.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  redirect('/listing_new.php');
}

$title = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = trim($_POST['price'] ?? '');

if ($title === '' || $category === '' || $description === '') {
  flash_set('error', 'Champs manquants.');
  redirect('/listing_new.php');
}

$userId = current_user_id();
$doc = [
  'userId' => (string)$userId,
  'title' => $title,
  'category' => $category,
  'description' => $description,
  'price' => ($price === '') ? null : (float)$price,
  'createdAt' => nowUtc(),
];

global $listingsCol;
$listingsCol->insertOne($doc);

flash_set('ok', 'Annonce publiée ✅');
redirect('/dashboard.php');
