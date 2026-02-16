<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../config.php';
require __DIR__ . '/../src/helpers.php';
require __DIR__ . '/../src/auth.php';

require_login();

$userId = current_user_id();

$myListings = iterator_to_array(
  $listingsCol->find(
    ['userId' => $userId],
    ['sort' => ['createdAt' => -1]]
  )
);

$countListings = count($myListings);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Dashboard • Campus</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<div class="container">

  <!-- Header / Welcome -->
  <div class="card">
    <div class="row" style="gap:16px;">
      <div style="flex:1;">
        <h2 style="margin:0;">Bienvenue <?= h($_SESSION['user_name'] ?? '') ?> 🎓</h2>
        <div class="muted">
          Ici tu gères tes annonces. <b><?= $countListings ?></b> annonce<?= $countListings > 1 ? 's' : '' ?>.
        </div>
      </div>

      <div class="actions" style="flex-wrap:wrap;">
        <a class="btn gray" href="/market.php">Marketplace</a>
        <a class="btn gray" href="/reservations.php">Réservations</a>
        <a class="btn green" href="/listing_new.php">+ Nouvelle annonce</a>
        <a class="btn red" href="/logout.php">Déconnexion</a>
      </div>
    </div>
  </div>

  <!-- Empty state -->
  <?php if ($countListings === 0): ?>
    <div class="card" style="margin-top:14px;">
      <h3 style="margin-top:0;">Tu n’as encore aucune annonce</h3>
      <p class="muted">Crée ta première annonce (logement, vente, service, etc.) pour qu’elle apparaisse ici.</p>
      <a class="btn green" href="/listing_new.php">+ Créer ma première annonce</a>
    </div>
  <?php else: ?>

    <!-- Grid listings -->
    <div class="grid">
      <?php foreach ($myListings as $x): ?>
        <div class="item">
          <h3 style="margin-bottom:6px;"><?= h($x['title'] ?? '') ?></h3>

          <div class="muted" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
            <span><?= h($x['category'] ?? 'Sans catégorie') ?></span>
            <?php if (!empty($x['createdAt']) && $x['createdAt'] instanceof MongoDB\BSON\UTCDateTime): ?>
              <span>•</span>
              <span>
                <?= h($x['createdAt']->toDateTime()->format('d/m/Y H:i')) ?>
              </span>
            <?php endif; ?>
          </div>

          <p class="muted" style="margin-top:10px;">
            <?= h(mb_strimwidth((string)($x['description'] ?? ''), 0, 140, '…')) ?>
          </p>

          <div class="actions" style="margin-top:12px;">
            <a class="btn gray" href="/listing_edit.php?id=<?= h((string)$x['_id']) ?>">Modifier</a>
            <a class="btn red"
               href="/listing_delete.php?id=<?= h((string)$x['_id']) ?>"
               onclick="return confirm('Supprimer cette annonce ?')">Supprimer</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>

</div>
</body>
</html>
