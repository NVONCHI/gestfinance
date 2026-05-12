<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;

/**
 * Script de migration pour mettre à jour la base de données.
 * Utilise la configuration définie dans App\Core\Database.
 */

$migrationsDir = __DIR__ . '/migrations';

try {
    $pdo = Database::getInstance();
    echo "Connexion à la base de données réussie.\n";
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage() . "\n");
}

// 1. Créer la table des migrations si elle n'existe pas
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration_name VARCHAR(255) NOT NULL UNIQUE,
            applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");
    echo "Table des migrations vérifiée/créée.\n";
} catch (PDOException $e) {
    die("Échec de la création de la table des migrations : " . $e->getMessage() . "\n");
}

// 2. Récupérer les migrations déjà appliquées
$stmt = $pdo->query("SELECT migration_name FROM migrations");
$appliedMigrations = $stmt->fetchAll(PDO::FETCH_COLUMN);

// 3. Récupérer les fichiers de migration disponibles
$migrationFiles = [];
if (is_dir($migrationsDir)) {
    $files = scandir($migrationsDir);
    foreach ($files as $file) {
        if (preg_match('/^\d{3}_.+\.sql$/', $file)) { // Correspond à des fichiers comme 001_create_tables.sql
            $migrationFiles[] = $file;
        }
    }
    sort($migrationFiles); // S'assurer que les migrations sont appliquées dans l'ordre
} else {
    die("Dossier des migrations non trouvé : " . $migrationsDir . "\n");
}

// 4. Appliquer les nouvelles migrations
$newMigrationsCount = 0;
foreach ($migrationFiles as $migrationFile) {
    if (!in_array($migrationFile, $appliedMigrations)) {
        echo "Application de la migration : " . $migrationFile . "\n";
        $sql = file_get_contents($migrationsDir . '/' . $migrationFile);

        if ($sql === false) {
            die("Impossible de lire le fichier de migration : " . $migrationFile . "\n");
        }

        try {
            // Note: MySQL ne supporte pas les transactions sur le DDL (CREATE, ALTER, etc.)
            // Ces instructions provoquent un commit implicite.
            $pdo->exec($sql);

            $stmt = $pdo->prepare("INSERT INTO migrations (migration_name) VALUES (?)");
            $stmt->execute([$migrationFile]);

            echo "Migration appliquée avec succès : " . $migrationFile . "\n";
            $newMigrationsCount++;
        } catch (PDOException $e) {
            die("Échec de l'application de la migration " . $migrationFile . " : " . $e->getMessage() . "\n");
        }
    }
}

if ($newMigrationsCount === 0) {
    echo "Aucune nouvelle migration à appliquer.\n";
} else {
    echo "Appliqué " . $newMigrationsCount . " nouvelle(s) migration(s).\n";
}

echo "Processus de migration terminé.\n";
