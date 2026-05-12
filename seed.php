<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use App\Enums\CategorieUtilisateur;
use App\Enums\ServiceTypeEnum;


echo "--- Démarrage du seeding ---\n";

try {
    $db = Database::getInstance();

    // 1. Insertion des Services via l'Enum ServiceType
    echo "Insertion des services...\n";
    $stmtService = $db->prepare("INSERT IGNORE INTO services (libelle, code, description) VALUES (?, ?, ?)");
    
    foreach (ServiceTypeEnum::cases() as $service) {
        $stmtService->execute([
            $service->label(),
            $service->value,
            $service->description()
        ]);
    }
    
    $infServiceId = $db->query("SELECT id FROM services WHERE code = '" . ServiceTypeEnum::INF->value . "'")->fetchColumn();
    $dgServiceId = $db->query("SELECT id FROM services WHERE code = '" . ServiceTypeEnum::DG->value . "'")->fetchColumn();

    // 2. Insertion des Rôles via l'Enum RoleType
    echo "Insertion des rôles...\n";
    $stmtRole = $db->prepare("INSERT IGNORE INTO roles (libelle, code, description) VALUES (?, ?, ?)");
    
    foreach (\App\Enums\RoleTypeEnum::cases() as $role) {
        $stmtRole->execute([
            $role->label(),
            $role->value,
            $role->description()
        ]);
    }
    
    $adminRoleId = $db->query("SELECT id FROM roles WHERE code = '" . \App\Enums\RoleTypeEnum::ADMIN->value . "'")->fetchColumn();
    $agentRoleId = $db->query("SELECT id FROM roles WHERE code = '" . \App\Enums\RoleTypeEnum::AGENT->value . "'")->fetchColumn();

    // 3. Préparation de l'insertion des utilisateurs
    $insertUserSql = "INSERT INTO users (nom, prenom, email, password_hash, service_id, role_id, categorie, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsertUser = $db->prepare($insertUserSql);
    
    $checkUserStmt = $db->prepare("SELECT id FROM users WHERE email = ?");

    // 4. Insertion de l'utilisateur Admin par défaut
    echo "Vérification de l'utilisateur administrateur...\n";
    $adminEmail = 'admin@gestfinance.com';
    $password = password_hash('admin123', PASSWORD_DEFAULT);

    $checkUserStmt->execute([$adminEmail]);
    if (!$checkUserStmt->fetch()) {
        $stmtInsertUser->execute([
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

    // 5. Insertion d'un Agent de test
    echo "Vérification de l'agent de test...\n";
    $agentEmail = 'agent@gestfinance.com';
    
    $checkUserStmt->execute([$agentEmail]);
    if (!$checkUserStmt->fetch()) {
        $stmtInsertUser->execute([
            'USER', 
            'Test', 
            $agentEmail, 
            $password, 
            $infServiceId, 
            $agentRoleId, 
            CategorieUtilisateur::AGENT->value, 
            1
        ]);
        echo "✅ Compte Agent créé : $agentEmail / admin123\n";
    } else {
        echo "ℹ️ L'utilisateur agent existe déjà.\n";
    }

    echo "--- Seeding terminé ---\n";
} catch (Exception $e) {
    echo "❌ Erreur lors du seeding : " . $e->getMessage() . "\n";
    exit(1);
}
