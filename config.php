<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/**
 * 1) On charge une config locale si elle existe (NE PAS COMMIT)
 *    -> tu mets MONGODB_URI dedans.
 * 2) Sinon on tente getenv('MONGODB_URI')
 */
$local = __DIR__ . '/config.local.php';
if (file_exists($local)) {
  require $local; // doit définir $MONGODB_URI (string) et optionnellement $DB_NAME
}

$MONGODB_URI = $MONGODB_URI ?? getenv('MONGODB_URI') ?: '';
$DB_NAME     = $DB_NAME ?? 'campus';

if (!$MONGODB_URI) {
  http_response_code(500);
  echo "❌ MONGODB_URI est vide.\n";
  echo "👉 Crée un fichier config.local.php à la racine avec :\n\n";
  echo "<?php\n\$MONGODB_URI = 'mongodb+srv://...';\n\$DB_NAME='campus';\n";
  exit;
}

$client = new Client($MONGODB_URI);
$db = $client->selectDatabase($DB_NAME);

// Collections (globales)
$usersCol        = $db->selectCollection('users');
$listingsCol     = $db->selectCollection('listings');
$reservationsCol = $db->selectCollection('reservations');
$messagesCol     = $db->selectCollection('messages');

// Helpers DB (facultatif)
function db(): \MongoDB\Database {
  global $db;
  return $db;
}
