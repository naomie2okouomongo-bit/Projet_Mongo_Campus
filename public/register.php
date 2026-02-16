<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $pass  = (string)($_POST['password'] ?? '');

  if ($name === '' || $email === '' || strlen($pass) < 6) {
    $error = "Remplis tout (mdp min 6 caractères).";
  } else if ($usersCol->findOne(['email' => $email])) {
    $error = "Cet email existe déjà.";
  } else {
    $usersCol->insertOne([
      'name' => $name,
      'email' => $email,
      'passwordHash' => password_hash($pass, PASSWORD_DEFAULT),
      'createdAt' => new MongoDB\BSON\UTCDateTime(),
    ]);

    header('Location: /login.php');
    exit;
  }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Inscription • Campus</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <div class="card" style="max-width:520px;margin:40px auto;">
    <h2>Créer un compte</h2>

    <?php if ($error): ?>
      <div class="alert"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <label>Nom</label>
      <input name="name" required>

      <label>Email</label>
      <input name="email" type="email" required>

      <label>Mot de passe</label>
      <input name="password" type="password" required>

      <button class="btn green" type="submit">S'inscrire</button>
    </form>

    <p class="muted" style="margin-top:12px;">
      Déjà un compte ? <a href="/login.php">Se connecter</a>
    </p>
  </div>
</div>
</body>
</html>
