<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Modèle Demande.
 */
class Demande extends Model
{
    protected string $table = 'demandes';

    /**
     * Crée une nouvelle demande.
     */
    public function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        return $stmt->execute(array_values($data));
    }

    /**
     * Récupère une demande avec les informations du demandeur et du service.
     */
    public function findWithDetails(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT d.*, u.nom, u.prenom, s.libelle as service_nom 
                                   FROM {$this->table} d 
                                   JOIN users u ON d.user_id = u.id 
                                   JOIN services s ON d.service_id = s.id 
                                   WHERE d.id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Récupère les demandes pour un utilisateur spécifique.
     */
    public function findByUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
