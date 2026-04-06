<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/**
 * Modèle Utilisateur.
 */
class Utilisateur extends Model
{
    /**
     * Retourne tous les utilisateurs.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        $sql = 'SELECT id_user, nom, prenom, telephone, email, role
                FROM users
                ORDER BY nom ASC, prenom ASC';

        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Recherche un utilisateur par email.
     *
     * @param string $email
     * @return array<string, mixed>|false
     */
    public function findByEmail(string $email): array|false
    {
        $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }

    /**
     * Recherche un utilisateur par identifiant.
     *
     * @param int $id
     * @return array<string, mixed>|false
     */
    public function findById(int $id): array|false
    {
        $sql = 'SELECT * FROM users WHERE id_user = :id';
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Retourne le nombre total d'utilisateurs.
     *
     * @return int
     */
    public function countAll(): int
    {
        $sql = 'SELECT COUNT(*) AS count FROM users';
        $stmt = $this->getDb()->query($sql);
        $row = $stmt->fetch();

        return $row !== false ? (int) $row['count'] : 0;
    }
}