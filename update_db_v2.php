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
    
    // 1. Ajouter le responsable_id aux services
    $stmt = $db->query("SHOW COLUMNS FROM services LIKE 'responsable_id'");
    if (!$stmt->fetch()) {
        $db->exec("ALTER TABLE services ADD COLUMN responsable_id INT NULL DEFAULT NULL AFTER description");
        $db->exec("ALTER TABLE services ADD CONSTRAINT fk_services_responsable FOREIGN KEY (responsable_id) REFERENCES users(id) ON DELETE SET NULL");
        echo "✅ Colonne responsable_id ajoutée aux services.\n";
    }

    // 2. S'assurer que les services existants ont un responsable (utile pour le seeder)
    $db->exec("UPDATE services SET responsable_id = (SELECT id FROM users WHERE categorie = 'responsable_directeur' LIMIT 1) WHERE responsable_id IS NULL");
    
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}
