<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

// Chargement de l'environnement
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

echo "--- Démarrage de la migration ---\n";

try {
    $db = Database::getInstance();
    $sqlFile = __DIR__ . '/migrations/001_create_tables.sql';

    if (!file_exists($sqlFile)) {
        throw new Exception("Fichier de migration introuvable : $sqlFile");
    }

    $sql = file_get_contents($sqlFile);
    
    // Exécuter le SQL (split par point-virgule pour gérer les multiples requêtes si nécessaire)
    $db->exec($sql);

    echo "✅ Migration terminée avec succès.\n";
} catch (Exception $e) {
    echo "❌ Erreur lors de la migration : " . $e->getMessage() . "\n";
    exit(1);
}
