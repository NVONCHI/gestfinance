<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Modèle Role.
 */
class Role extends Model
{
    protected string $table = 'roles';

    public function allWithParents(): array
    {
        $stmt = $this->db->query("
            SELECT r1.*, r2.libelle as parent_libelle 
            FROM {$this->table} r1 
            LEFT JOIN {$this->table} r2 ON r1.parent_id = r2.id
            ORDER BY r1.parent_id ASC, r1.libelle ASC
        ");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        return $stmt->execute(array_values($data));
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = ?";
        return $this->db->prepare($sql)->execute($values);
    }
}
