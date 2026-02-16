<?php
declare(strict_types=1);

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

if (!function_exists('h')) {
  function h($v): string {
    return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
  }
}

if (!function_exists('oid')) {
  function oid(string $id): ObjectId {
    return new ObjectId($id);
  }
}

if (!function_exists('nowUtc')) {
  function nowUtc(): UTCDateTime {
    return new UTCDateTime((int)(microtime(true) * 1000));
  }
}

if (!function_exists('redirect')) {
  function redirect(string $path): never {
    header("Location: {$path}");
    exit;
  }
}

if (!function_exists('flash_set')) {
  function flash_set(string $key, string $msg): void {
    $_SESSION['_flash'][$key] = $msg;
  }
}

if (!function_exists('flash_get')) {
  function flash_get(string $key): ?string {
    $msg = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $msg;
  }
}
