<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modèle de base pour l'interaction avec la base de données.
 */
abstract class Model
{
    protected PDO $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Trouve un enregistrement par son ID.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Récupère tous les enregistrements.
     */
    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Supprime un enregistrement par son ID.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM information_schema.columns WHERE table_name = ? AND column_name = 'deleted_at'");
        $stmt->execute([$this->table]);
        $hasDeletedAt = (bool) $stmt->fetchColumn();

        if ($hasDeletedAt) {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE id = ?");
        } else {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        }
        
        return $stmt->execute([$id]);
    }
}
