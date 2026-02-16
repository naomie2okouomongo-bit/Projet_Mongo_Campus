<?php
declare(strict_types=1);

function layout_top(string $title = 'Campus'): void {
  $userName = $_SESSION['user_name'] ?? '';
  $isLogged = !empty($_SESSION['user_id']);
  ?>
  <!doctype html>
  <html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($title) ?></title>
    <link rel="stylesheet" href="/assets/style.css">
  </head>
  <body>
  <header class="topbar">
    <div class="container topbar__inner">
      <a class="brand" href="<?= $isLogged ? '/dashboard.php' : '/login.php' ?>">Campus</a>

      <nav class="nav">
        <a href="/market.php">Marketplace</a>
        <?php if ($isLogged): ?>
          <a href="/dashboard.php">Mes annonces</a>
          <a href="/reservations.php">Réservations</a>
          <a class="btn btn--primary" href="/listing_new.php">+ Nouvelle annonce</a>
          <a class="btn btn--danger" href="/logout.php">Déconnexion</a>
        <?php else: ?>
          <a href="/login.php">Connexion</a>
          <a class="btn btn--primary" href="/register.php">Créer un compte</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="container">
  <?php if ($isLogged): ?>
    <div class="welcome muted">Connecté·e : <b><?= h($userName) ?></b></div>
  <?php endif; ?>
  <?php
}

function layout_bottom(): void {
  ?>
  </main>
  <footer class="footer">
    <div class="container muted">Campus • Projet MongoDB</div>
  </footer>
  </body>
  </html>
  <?php
}
