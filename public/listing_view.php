<?php
require_once __DIR__ . '/../bootstrap.php';
require_login();

$id = $_GET['id'] ?? '';
if ($id === '') {
  header('Location: /dashboard.php'); exit;
}

$item = $listingsCol->findOne(['_id' => oid($id)]);
if (!$item) {
  layout_top('Annonce introuvable');
  echo '<section class="empty"><h2>Annonce introuvable</h2><p class="muted">Cette annonce n’existe plus.</p><a class="btn btn--primary" href="/dashboard.php">Retour</a></section>';
  layout_bottom();
  exit;
}

layout_top('Annonce • '.($item['title'] ?? ''));
?>

<section class="card">
  <h1><?= h($item['title'] ?? '') ?></h1>
  <div class="muted"><?= h($item['category'] ?? 'Sans catégorie') ?></div>
  <p style="margin-top:12px;"><?= nl2br(h((string)($item['description'] ?? ''))) ?></p>

  <div class="card__actions">
    <a class="btn btn--ghost" href="/dashboard.php">Retour</a>
    <a class="btn btn--ghost" href="/listing_edit.php?id=<?= h((string)$item['_id']) ?>">Modifier</a>
  </div>
</section>

<?php layout_bottom(); ?>
