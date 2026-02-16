<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../src/helpers.php';
require __DIR__ . '/../src/auth.php';
require_login();

$id = $_GET['id'] ?? '';
if ($id === '') redirect('/dashboard.php');

$item = $listingsCol->findOne(['_id' => oid($id)]);
if (!$item) redirect('/dashboard.php');
if (($item['userId'] ?? '') !== current_user_id()) redirect('/dashboard.php');

$listingsCol->deleteOne(['_id' => oid($id)]);

redirect('/dashboard.php');
