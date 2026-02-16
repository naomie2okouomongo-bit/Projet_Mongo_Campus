<?php
require __DIR__ . '/../vendor/autoload.php';

function db(): MongoDB\Database {
    $uri = getenv('MONGODB_URI');
    if (!$uri) {
        throw new Exception("MONGODB_URI manquant (variable d'environnement)");
    }

    $client = new MongoDB\Client($uri);
    return $client->selectDatabase("fridgesaver");
}
