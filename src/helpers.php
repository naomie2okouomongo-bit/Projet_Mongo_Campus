<?php
if (defined('APP_HELPERS_LOADED')) { return; }
define('APP_HELPERS_LOADED', true);

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

function h($v) {
  return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

function oid(string $id): ObjectId {
  return new ObjectId($id);
}

function nowUtc(): UTCDateTime {
  return new UTCDateTime((int)(microtime(true) * 1000));
}

function redirect(string $path): never {
  header("Location: {$path}");
  exit;
}

function flash_set(string $key, string $msg): void {
  $_SESSION['_flash'][$key] = $msg;
}

function flash_get(string $key): ?string {
  $msg = $_SESSION['_flash'][$key] ?? null;
  unset($_SESSION['_flash'][$key]);
  return $msg;
}
