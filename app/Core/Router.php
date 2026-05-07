<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Routeur simple pour gérer les requêtes et les dispatcher aux contrôleurs.
 */
class Router
{
    private array $routes = [];

    /**
     * Ajoute une route GET.
     */
    public function get(string $path, callable|array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Ajoute une route POST.
     */
    public function post(string $path, callable|array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * Enregistre une route.
     */
    private function addRoute(string $method, string $path, callable|array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    /**
     * Résout la requête actuelle.
     */
    public function resolve(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        // Détection automatique du chemin de base (si le projet est dans un sous-dossier)
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $baseDir = dirname($scriptName);
        
        // Si le chemin commence par le baseDir, on le retire pour le matching
        if ($baseDir !== '/' && strpos($path, $baseDir) === 0) {
            $path = substr($path, strlen($baseDir));
        }
        
        // Assurer que le path commence par /
        if ($path === '' || $path === false) {
            $path = '/';
        }

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $route['path']);
            $pattern = "@^" . $pattern . "$@D";

            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler = $route['handler'];

                if (is_array($handler)) {
                    [$controllerClass, $methodName] = $handler;
                    if (!class_exists($controllerClass)) {
                        throw new \Exception("La classe contrôleur '$controllerClass' est introuvable.");
                    }
                    $controller = new $controllerClass();
                    if (!method_exists($controller, $methodName)) {
                        throw new \Exception("La méthode '$methodName' est introuvable dans '$controllerClass'.");
                    }
                    call_user_func_array([$controller, $methodName], $params);
                } else {
                    call_user_func_array($handler, $params);
                }
                return;
            }
        }

        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>La route <strong>$path</strong> (URI: $uri) n'existe pas dans la configuration du routeur.</p>";
    }
}
