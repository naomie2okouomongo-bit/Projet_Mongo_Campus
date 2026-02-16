<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/auth.php';


// Si pas connecté -> login
if (!auth_is_logged_in()) {
  header('Location: /login.php');
  exit;
}

// Si connecté -> dashboard
header('Location: /dashboard.php');
exit;


$db = db();
$col = $db->listings;

$q = trim($_GET['q'] ?? '');
$type = trim($_GET['type'] ?? '');

$filter = [];
if ($q !== '') {
  $filter['$or'] = [
    ['title' => ['$regex' => $q, '$options' => 'i']],
    ['description' => ['$regex' => $q, '$options' => 'i']],
    ['category' => ['$regex' => $q, '$options' => 'i']],
  ];
}
if ($type !== '' && in_array($type, ['sale','gift','swap'], true)) {
  $filter['type'] = $type;
}

$cursor = $col->find($filter, ['sort' => ['createdAt' => -1]]);
$listings = iterator_to_array($cursor);

$title = "CampusSwap — Annonces";
require_once __DIR__ . '/_layout_top.php';
?>

<div class="card">
  <div class="row">
    <div>
      <h2 style="margin:0;">Annonces</h2>
      <div class="muted">Crée une annonce, recherche, modifie, supprime.</div>
    </div>
    <a class="btn green" href="listing_new.php">+ Nouvelle annonce</a>
  </div>

  <hr>

  <form class="row" method="GET" action="index.php">
    <div style="flex:1;min-width:220px">
      <label>Recherche</label>
      <input name="q" value="<?= h($q) ?>" placeholder="Ex: calculatrice, livre, casque...">
    </div>
    <div style="width:220px">
      <label>Type</label>
      <select name="type">
        <option value="">Tous</option>
        <option value="sale" <?= $type==='sale'?'selected':'' ?>>Vente</option>
        <option value="gift" <?= $type==='gift'?'selected':'' ?>>Don</option>
        <option value="swap" <?= $type==='swap'?'selected':'' ?>>Échange</option>
      </select>
    </div>
    <div style="align-self:end">
      <button class="btn gray" type="submit">Rechercher</button>
    </div>
  </form>
</div>

<div class="grid">
  <?php foreach ($listings as $x): ?>
    <?php
      $status = $x['status'] ?? 'available';
      $price = (float)($x['price'] ?? 0);
      $typeLabel = match($x['type'] ?? 'sale') {
        'gift' => 'Don',
        'swap' => 'Échange',
        default => 'Vente'
      };
    ?>
    <div class="item">
      <div class="row">
        <span class="badge <?= badgeClass($status) ?>"><?= statusLabel($status) ?></span>
        <span class="pill"><?= h($typeLabel) ?></span>
      </div>

      <h3><?= h($x['title'] ?? '') ?></h3>
      <div class="muted"><?= h($x['category'] ?? 'Sans catégorie') ?></div>

      <p class="muted" style="margin:10px 0 0;">
        <?= h(mb_strimwidth((string)($x['description'] ?? ''), 0, 140, '…')) ?>
      </p>

      <div class="row" style="margin-top:10px">
        <div class="price">
          <?= ($x['type'] ?? '') === 'gift' ? '0€' : number_format($price, 2, ',', ' ') . '€' ?>
        </div>
        <div class="muted">
          <?= isset($x['createdAt']) ? $x['createdAt']->toDateTime()->format('d/m/Y') : '' ?>
        </div>
      </div>

      <div class="actions">
        <a class="btn gray" href="listing_edit.php?id=<?= h((string)$x['_id']) ?>">Modifier</a>
        <a class="btn red" href="listing_delete.php?id=<?= h((string)$x['_id']) ?>" onclick="return confirm('Supprimer cette annonce ?')">Supprimer</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/_layout_bottom.php'; ?>
