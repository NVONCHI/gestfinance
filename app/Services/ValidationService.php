<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Enums\StatutDemande;
use App\Enums\CategorieUtilisateur;

class ValidationService
{
    /**
     * Valide une demande par un utilisateur.
     */
    public function validate(int $demandeId, int $userId, string $commentaire): bool
    {
        
        $db = Database::getInstance();
        
        // 1. Récupérer la demande
        $stmt = $db->prepare("SELECT * FROM demandes WHERE id = ?");
        $stmt->execute([$demandeId]);
        $demande = $stmt->fetch();

        // 2. Récupérer le valideur
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        $newStatus = $demande['statut'];
        $etape = '';

        // Logique de transition
        switch ($user['categorie']) {
            case CategorieUtilisateur::RESPONSABLE_DIRECTEUR->value:
                $newStatus = StatutDemande::VALIDE_DIRECTEUR->value;
                $etape = 'directeur';
                break;
            case CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value:
                $newStatus = StatutDemande::VALIDE_RA->value;
                $etape = 'responsable_administratif';
                break;
            case CategorieUtilisateur::DG->value:
                $newStatus = StatutDemande::ENREGISTRE->value;
                $etape = 'dg';
                break;
        }

        $db->beginTransaction();
        try {
            // Mise à jour du statut
            $stmt = $db->prepare("UPDATE demandes SET statut = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$newStatus, $demandeId]);

            // Enregistrement de la validation
            $stmt = $db->prepare("INSERT INTO validations (demande_id, validateur_id, action, commentaire, etape) VALUES (?, ?, 'validation', ?, ?)");
            $stmt->execute([$demandeId, $userId, $commentaire, $etape]);

            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    /**
     * Rejette une demande.
     */
    public function reject(int $demandeId, int $userId, string $commentaire): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE demandes SET statut = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([StatutDemande::REJETE->value, $demandeId]);
    }
}
