<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum représentant les catégories d'utilisateurs.
 */
enum CategorieUtilisateur: string
{
    case AGENT = 'agent';
    case RESPONSABLE_DIRECTEUR = 'responsable_directeur';
    case DG = 'dg';
    case RESPONSABLE_ADMINISTRATIF = 'responsable_administratif';
    case SUPER_ADMIN = 'super_admin';

    /**
     * Retourne le libellé lisible de la catégorie.
     */
    public function label(): string
    {
        return match ($this) {
            self::AGENT => 'Agent',
            self::RESPONSABLE_DIRECTEUR => 'Responsable / Directeur',
            self::DG => 'Directeur Général',
            self::SUPER_ADMIN=>'Super Administrateur',
            self::RESPONSABLE_ADMINISTRATIF => 'Responsable Administratif',
        };
    }
}
