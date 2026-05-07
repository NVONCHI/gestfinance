<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * Contrôleur de base.
 */
abstract class Controller
{
    /**
     * Rend une vue.
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        
        // Normaliser le chemin de la vue
        $viewPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $view);
        $contentFile = realpath(__DIR__ . "/../../views/{$viewPath}.php");
        
        if (!$contentFile || !file_exists($contentFile)) {
            die("Vue non trouvée : " . __DIR__ . "/../../views/{$viewPath}.php");
        }

        // Breadcrumbs par défaut si non fournis
        if (!isset($breadcrumbs)) {
            $breadcrumbs = [
                ['label' => 'Accueil', 'url' => '/']
            ];
        }

        ob_start();
        require $contentFile;
        $content = ob_get_clean();

        $layoutFile = realpath(__DIR__ . "/../../views/layouts/main.php");
        if (!$layoutFile || !file_exists($layoutFile)) {
            echo $content;
            return;
        }

        require $layoutFile;
    }

    /**
     * Redirige vers une URL.
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Retourne une réponse JSON.
     */
    protected function json(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
