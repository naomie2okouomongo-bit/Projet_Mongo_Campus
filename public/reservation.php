<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/auth.php';
require_login();

$uid = (string)current_user_id();

$reservations = iterator_to_array(
  $reservationsCol->find(
    ['$or' => [['buyerId' => $uid], ['sellerId' => $uid]]],
    ['sort' => ['createdAt' => -1]]
  )
);

// map listingId -> title
$listingIds = [];
foreach ($reservations as $r) $listingIds[] = $r['listingId'] ?? '';
$listingIds = array_values(array_unique(array_filter($listingIds)));

$listMap = [];
if ($listingIds) {
  $cursor = $listingsCol->find(['_id' => ['$in' => array_map(fn($id)=> oid($id), $listingIds)]]);
  foreach ($cursor as $l) $listMap[(string)$l['_id']] = (string)($l['title'] ?? '');
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mes réservations</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <div class="card">
    <div class="row">
      <div>
        <h2 style="margin:0;">Mes réservations</h2>
        <div class="muted">Tu vois tes demandes + celles reçues.</div>
      </div>
      <div class="actions">
        <a class="btn gray" href="/dashboard.php">Dashboard</a>
        <a class="btn gray" href="/market.php">Marketplace</a>
      </div>
    </div>
  </div>

  <div class="grid">
    <?php foreach ($reservations as $r): ?>
      <?php
        $rid = (string)$r['_id'];
        $lid = (string)($r['listingId'] ?? '');
        $title = $listMap[$lid] ?? 'Annonce';
        $status = (string)($r['status'] ?? 'pending');
      ?>
      <div class="item">
        <h3><?= h($title) ?></h3>
        <div class="pill">Statut: <strong><?= h($status) ?></strong></div>

        <div class="actions" style="margin-top:10px;">
          <a class="btn green" href="/reservation_chat.php?id=<?= h($rid) ?>">Ouvrir chat</a>

          <?php if (($r['sellerId'] ?? '') === $uid && $status === 'pending'): ?>
            <a class="btn green" href="/reservation_set_status.php?id=<?= h($rid) ?>&s=accepted">Accepter</a>
            <a class="btn red" href="/reservation_set_status.php?id=<?= h($rid) ?>&s=rejected">Refuser</a>
          <?php endif; ?>

          <?php if (($r['buyerId'] ?? '') === $uid && $status === 'pending'): ?>
            <a class="btn red" href="/reservation_set_status.php?id=<?= h($rid) ?>&s=cancelled">Annuler</a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
