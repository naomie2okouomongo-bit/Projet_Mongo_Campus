<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/auth.php';

require_login();

$userId = current_user_id();

$myListings = iterator_to_array(
  $listingsCol->find(['userId' => $userId], ['sort' => ['createdAt' => -1]])
);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard • Campus</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <div class="card">
    <div class="row">
      <div>
        <h2 style="margin:0;">Bienvenue <?= h($_SESSION['user_name'] ?? '') ?> 🎓</h2>
        <div class="muted">Ici tu gères tes annonces.</div>
      </div>
      <div class="actions">
        <a class="btn green" href="/listing_new.php">+ Nouvelle annonce</a>
        <a class="btn red" href="/logout.php">Déconnexion</a>
      </div>
    </div>
  </div>

  <div class="grid">
    <?php if (count($myListings) === 0): ?>
      <div class="card">
        <p class="muted">Tu n’as pas encore d’annonce. Clique sur “+ Nouvelle annonce”.</p>
      </div>
    <?php endif; ?>

    <?php foreach ($myListings as $x): ?>
      <div class="item">
        <h3><?= h($x['title'] ?? '') ?></h3>
        <div class="muted"><?= h($x['category'] ?? 'Sans catégorie') ?></div>
        <p class="muted" style="margin-top:10px;">
          <?= h(mb_strimwidth((string)($x['description'] ?? ''), 0, 120, '…')) ?>
        </p>
        <div class="actions">
          <a class="btn gray" href="/listing_edit.php?id=<?= h((string)$x['_id']) ?>">Modifier</a>
          <a class="btn red" href="/listing_delete.php?id=<?= h((string)$x['_id']) ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
          <a class="btn gray" href="/market.php">Marketplace</a>
          <a class="btn gray" href="/reservation.php">Réservations</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
