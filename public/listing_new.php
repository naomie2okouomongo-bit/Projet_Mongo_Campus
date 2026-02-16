<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/auth.php';

require_login();

$error = flash_get('error');
$ok = flash_get('ok');
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Nouvelle annonce</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<div class="container">
  <div class="card">
    <h2>➕ Nouvelle annonce</h2>

    <?php if ($error): ?>
      <div class="alert error"><?= h($error) ?></div>
    <?php endif; ?>
    <?php if ($ok): ?>
      <div class="alert ok"><?= h($ok) ?></div>
    <?php endif; ?>

    <form method="post" action="/listing_create.php" class="form">
      <label>Titre</label>
      <input name="title" required maxlength="80" placeholder="Ex: Chambre à louer">

      <label>Catégorie</label>
      <select name="category" required>
        <option value="">-- choisir --</option>
        <option>Logement</option>
        <option>Vente</option>
        <option>Service</option>
        <option>Autre</option>
      </select>

      <label>Description</label>
      <textarea name="description" required rows="6" placeholder="Décris ton annonce..."></textarea>

      <label>Prix (optionnel)</label>
      <input name="price" type="number" step="0.01" min="0" placeholder="Ex: 120">

      <div style="display:flex; gap:10px; margin-top:12px;">
        <button class="btn green" type="submit">Publier</button>
        <a class="btn gray" href="/dashboard.php">Retour</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>
