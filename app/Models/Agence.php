<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/**
 * Modèle Agence.
 */
class Agence extends Model
{
    /**
     * Retourne toutes les agences.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        $sql  = 'SELECT * FROM agences ORDER BY nom ASC';
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Recherche une agence par son identifiant.
     *
     * @param int $id
     * @return array<string, mixed>|false
     */
    public function findById(int $id): array|false
    {
        $sql  = 'SELECT * FROM agences WHERE id_agence = :id';
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Crée une agence.
     *
     * @param string $nom
     * @return bool
     */
    public function create(string $nom): bool
    {
        $sql  = 'INSERT INTO agences (nom) VALUES (:nom)';
        $stmt = $this->getDb()->prepare($sql);

        return $stmt->execute(['nom' => $nom]);
    }

    /**
     * Met à jour une agence.
     *
     * @param int $id
     * @param string $nom
     * @return bool
     */
    public function update(int $id, string $nom): bool
    {
        $sql  = 'UPDATE agences SET nom = :nom WHERE id_agence = :id';
        $stmt = $this->getDb()->prepare($sql);

        return $stmt->execute([
            'id'  => $id,
            'nom' => $nom,
        ]);
    }

    /**
     * Supprime une agence.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql  = 'DELETE FROM agences WHERE id_agence = :id';
        $stmt = $this->getDb()->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Retourne le nombre total d'agences.
     *
     * @return int
     */
    public function countAll(): int
    {
        $sql  = 'SELECT COUNT(*) AS count FROM agences';
        $stmt = $this->getDb()->query($sql);
        $row  = $stmt->fetch();

        return $row !== false ? (int) $row['count'] : 0;
    }
}