<?php

declare(strict_types=1);

namespace App\Core;

use App\Enums\CategorieUtilisateur;
use App\Enums\SpaceEnum;

/**
 * Helper pour gérer l'authentification et les droits d'accès sans manipuler $_SESSION directement.
 */
class AuthHelper
{
    /**
     * Vérifie si un utilisateur est connecté.
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Récupère l'ID de l'utilisateur connecté.
     */
    public static function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Récupère le nom complet de l'utilisateur.
     */
    public static function getUserName(): string
    {
        return $_SESSION['user_name'] ?? 'Invité';
    }

    /**
     * Récupère la catégorie (rôle métier) de l'utilisateur.
     */
    public static function getCategory(): ?string
    {
        return $_SESSION['user_category'] ?? null;
    }

    /**
     * Récupère l'espace de connexion actuel (admin ou user).
     */
    public static function getSpace(): string
    {
        return $_SESSION['user_space'] ?? 'user';
    }

    /**
     * Récupère l'ID du service de l'utilisateur.
     */
    public static function getServiceId(): ?int
    {
        return $_SESSION['service_id'] ?? null;
    }

    /**
     * Vérifie si l'utilisateur est un Agent.
     */
    public static function isAgent(): bool
    {
        return self::getCategory() === CategorieUtilisateur::AGENT->value;
    }

    /**
     * Vérifie si l'utilisateur est un Responsable/Directeur.
     */
    public static function isDirector(): bool
    {
        return self::getCategory() === CategorieUtilisateur::RESPONSABLE_DIRECTEUR->value;
    }

    /**
     * Vérifie si l'utilisateur est le DG.
     */
    public static function isDG(): bool
    {
        return self::getCategory() === CategorieUtilisateur::DG->value;
    }

    /**
     * Vérifie si l'utilisateur est le Responsable Administratif (RA).
     */
    public static function isRA(): bool
    {
        return self::getCategory() === CategorieUtilisateur::RESPONSABLE_ADMINISTRATIF->value;
    }

    /**
     * Vérifie si l'utilisateur est dans l'espace Administration.
     */
    public static function isAdminSpace(): bool
    {
        return self::getSpace() === SpaceEnum::ADMIN->value || (self::getSpace() === SpaceEnum::SUPER_ADMIN->value);
    }

    public static function isUserSpace(): bool
    {
        return self::getSpace() === SpaceEnum::USER->value;
    }

    public static function isSuperAdminSpace(): bool
    {
        return self::getSpace() === SpaceEnum::SUPER_ADMIN->value;
    }
    
    
}
