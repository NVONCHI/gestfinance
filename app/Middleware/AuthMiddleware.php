<?php

declare(strict_types=1);

namespace App\Middleware;

/**
 * Middleware pour vérifier si l'utilisateur est authentifié.
 */
class AuthMiddleware
{
    public static function handle(): void
    {
        if (!\App\Core\AuthHelper::isLoggedIn()) {
            header("Location: /login");
            exit;
        }
    }
}
