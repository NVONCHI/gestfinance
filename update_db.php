<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

try {
    $db = Database::getInstance();
    
    // Check if parent_id exists
    $stmt = $db->query("SHOW COLUMNS FROM roles LIKE 'parent_id'");
    $exists = $stmt->fetch();
    
    if (!$exists) {
        $db->exec("ALTER TABLE roles ADD COLUMN parent_id INT NULL DEFAULT NULL AFTER id");
        $db->exec("ALTER TABLE roles ADD CONSTRAINT fk_roles_parent FOREIGN KEY (parent_id) REFERENCES roles(id) ON DELETE SET NULL");
        echo "✅ Colonne parent_id ajoutée avec succès à la table roles.\n";
    } else {
        echo "ℹ️ La colonne parent_id existe déjà.\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}
