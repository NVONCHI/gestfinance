<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use App\Enums\CategorieUtilisateur;
use Dotenv\Dotenv;

// Chargement de l'environnement
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

echo "--- Démarrage du seeding ---\n";

try {
    $db = Database::getInstance();

    // 1. Insertion des Services
    echo "Insertion des services...\n";
    $services = [
        ['Informatique', 'INF', 'Direction des Systèmes d\'Information'],
        ['Ressources Humaines', 'RH', 'Gestion du personnel'],
        ['Comptabilité', 'COMPTA', 'Gestion financière et comptable'],
        ['Direction Générale', 'DG', 'Administration générale'],
    ];

    $stmt = $db->prepare("INSERT IGNORE INTO services (libelle, code, description) VALUES (?, ?, ?)");
    foreach ($services as $s) {
        $stmt->execute($s);
    }
    $infServiceId = $db->query("SELECT id FROM services WHERE code = 'INF'")->fetchColumn();
    $dgServiceId = $db->query("SELECT id FROM services WHERE code = 'DG'")->fetchColumn();

    // 2. Insertion des Rôles
    echo "Insertion des rôles...\n";
    $roles = [
        ['Administrateur', 'ADMIN', 'Accès total au système'],
        ['Agent', 'AGENT', 'Utilisateur standard'],
        ['Directeur', 'DIR', 'Responsable de service'],
    ];

    $stmt = $db->prepare("INSERT IGNORE INTO roles (libelle, code, description) VALUES (?, ?, ?)");
    foreach ($roles as $r) {
        $stmt->execute($r);
    }
    $adminRoleId = $db->query("SELECT id FROM roles WHERE code = 'ADMIN'")->fetchColumn();

    // 3. Insertion de l'utilisateur Admin par défaut
    echo "Insertion de l'utilisateur administrateur...\n";
    $adminEmail = 'admin@gestfinance.com';
    $password = password_hash('admin123', PASSWORD_DEFAULT);

    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$adminEmail]);
    
    if (!$stmt->fetch()) {
        $stmt = $db->prepare("INSERT INTO users (nom, prenom, email, password_hash, service_id, role_id, categorie, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            'ADMIN', 
            'System', 
            $adminEmail, 
            $password, 
            $dgServiceId, 
            $adminRoleId, 
            CategorieUtilisateur::DG->value, 
            1
        ]);
        echo "✅ Compte Admin créé : $adminEmail / admin123\n";
    } else {
        echo "ℹ️ L'utilisateur admin existe déjà.\n";
    }

    // 4. Insertion d'un Agent de test
    $agentEmail = 'agent@gestfinance.com';
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$agentEmail]);
    
    if (!$stmt->fetch()) {
        $stmt->execute([
            'USER', 
            'Test', 
            $agentEmail, 
            $password, 
            $infServiceId, 
            null, 
            CategorieUtilisateur::AGENT->value, 
            1
        ]);
        echo "✅ Compte Agent créé : $agentEmail / admin123\n";
    }

    echo "--- Seeding terminé ---\n";
} catch (Exception $e) {
    echo "❌ Erreur lors du seeding : " . $e->getMessage() . "\n";
    exit(1);
}
