<?php

declare(strict_types=1);

// Activation des erreurs pour le débogage
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use Dotenv\Dotenv;

try {
    // Chargement de l'environnement
    if (file_exists(__DIR__ . '/../.env')) {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
    }

    // Démarrage de la session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Chargement des routes
    $router = new Router();
    require_once __DIR__ . '/../routes/web.php';

    // Résolution de la route
    $router->resolve();
} catch (\Exception $e) {
    echo "<h1>Erreur Système</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
