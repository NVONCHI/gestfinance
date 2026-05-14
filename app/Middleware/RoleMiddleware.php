<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Enums\CategorieUtilisateur;

/**
 * Middleware pour vérifier les rôles des utilisateurs.
 */
class RoleMiddleware
{
    public static function handle(array $allowedCategories): void
    {
        AuthMiddleware::handle();

        $userCategory = \App\Core\AuthHelper::getCategory();

        if (!in_array($userCategory, $allowedCategories)) {
            http_response_code(403);
            die("Accès interdit : vous n'avez pas les droits nécessaires.");
        }
    }
}
