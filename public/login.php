<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/helpers.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass  = (string)($_POST['password'] ?? '');

  $user = $usersCol->findOne(['email' => $email]);

  if (!$user || !password_verify($pass, $user['passwordHash'] ?? '')) {
    $error = "Email ou mot de passe incorrect.";
  } else {
    $_SESSION['user_id']   = (string)$user['_id'];
    $_SESSION['user_name'] = (string)($user['name'] ?? '');
    header('Location: /dashboard.php');
    exit;
  }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion • Campus</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <div class="card" style="max-width:520px;margin:40px auto;">
    <h2>Connexion</h2>
    <?php if ($error): ?>
      <div class="alert"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <label>Email</label>
      <input name="email" type="email" required>

      <label>Mot de passe</label>
      <input name="password" type="password" required>

      <button class="btn green" type="submit">Se connecter</button>
    </form>

    <p class="muted" style="margin-top:12px;">
      Pas de compte ? <a href="/register.php">Créer un compte</a>
    </p>
  </div>
</div>
</body>
</html>
