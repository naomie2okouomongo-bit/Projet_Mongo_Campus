<?php
require __DIR__ . '/vendor/autoload.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


$raw = getenv('MONGODB_URI');
$MONGODB_URI = $raw ? trim(preg_replace('/\s+/', '', $raw)) : '';
$DB_NAME = getenv('MONGODB_DB') ? trim(getenv('MONGODB_DB')) : 'campusdb';

if ($MONGODB_URI === '') {
  die("❌ MONGODB_URI est vide (env non défini).");
}

// sécurité: caractères interdits qui apparaissent quand on copie mal
if (str_contains($MONGODB_URI, '<') || str_contains($MONGODB_URI, '>')) {
  die("❌ Ton MONGODB_URI contient < ou > (copie/placeholder). Corrige la variable d’environnement.");
}

$client = new MongoDB\Client($MONGODB_URI);
$db = $client->selectDatabase($DB_NAME);

$usersCol    = $db->selectCollection('users');
$listingsCol = $db->selectCollection('listings');
$reservationsCol = $db->selectCollection('reservations');
$messagesCol = $db->selectCollection('messages');
