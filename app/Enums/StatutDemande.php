<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum représentant les différents statuts d'une demande de besoin financier.
 */
enum StatutDemande: string
{
    case BROUILLON = 'brouillon';
    case SOUMIS = 'soumis';
    case VALIDE_DIRECTEUR = 'valide_directeur';
    case VALIDE_DG = 'valide_dg';
    case ENREGISTRE = 'enregistre';
    case REJETE = 'rejete';

    /**
     * Retourne le libellé lisible du statut.
     */
    public function label(): string
    {
        return match ($this) {
            self::BROUILLON => 'Brouillon',
            self::SOUMIS => 'Soumis',
            self::VALIDE_DIRECTEUR => 'Validé par Directeur',
            self::VALIDE_DG => 'Validé par DG',
            self::ENREGISTRE => 'Enregistré',
            self::REJETE => 'Rejeté',
        };
    }

    /**
     * Retourne la couleur associée au statut pour le Material Design.
     */
    public function color(): string
    {
        return match ($this) {
            self::BROUILLON => '#74777F', // Outline color (Grey)
            self::SOUMIS => '#F57C00',    // Orange
            self::VALIDE_DIRECTEUR => '#0288D1', // Light Blue
            self::VALIDE_DG => '#1565C0',        // Primary Blue
            self::ENREGISTRE => '#2E7D32',       // Green
            self::REJETE => '#C62828',           // Red
        };
    }
}
