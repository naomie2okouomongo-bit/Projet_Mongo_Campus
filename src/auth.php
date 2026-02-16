<?php
require_once __DIR__ . '/helpers.php';

function auth_is_logged_in(): bool {
  return !empty($_SESSION['user_id']);
}

function current_user_id(): ?string {
  return $_SESSION['user_id'] ?? null;
}

function require_login(): void {
  if (!auth_is_logged_in()) {
    header('Location: /login.php');
    exit;
  }
}
