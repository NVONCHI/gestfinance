<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use Dotenv\Dotenv;

/**
 * Singleton pour la connexion à la base de données via PDO.
 */
class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    /**
     * Retourne l'instance unique de PDO.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                // Charger .env si non défini
                if (!isset($_ENV['DB_HOST'])) {
                    $dotenvPath = realpath(__DIR__ . '/../../');
                    if (file_exists($dotenvPath . '/.env')) {
                        $dotenv = Dotenv::createImmutable($dotenvPath);
                        $dotenv->load();
                    }
                }

                $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
                $port = $_ENV['DB_PORT'] ?? '3306';
                $db   = $_ENV['DB_DATABASE'] ?? 'gestfinance';
                $user = $_ENV['DB_USERNAME'] ?? 'root';
                $pass = $_ENV['DB_PASSWORD'] ?? '';

                $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                // Au lieu de die(), on affiche une erreur plus propre pour le debug
                throw new \Exception("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
