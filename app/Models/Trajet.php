<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/**
 * Modèle Trajet.
 */
class Trajet extends Model
{
    /**
     * Retourne les trajets disponibles pour l'accueil
     * et la vue utilisateur connecté : trajets futurs
     * avec des places disponibles, triés par date de départ.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAvailable(): array
    {
        $sql = "SELECT t.*,
                       ad.nom AS ville_depart,
                       aa.nom AS ville_arrivee,
                       u.nom AS nom_user,
                       u.prenom,
                       u.telephone,
                       u.email
                FROM trajets t
                INNER JOIN agences ad ON t.id_agence_depart = ad.id_agence
                INNER JOIN agences aa ON t.id_agence_arrivee = aa.id_agence
                INNER JOIN users u ON t.id_user = u.id_user
                WHERE t.date_depart > NOW()
                  AND t.places_disponibles > 0
                ORDER BY t.date_depart ASC";

        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Retourne tous les trajets (vue admin).
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        $sql = "SELECT t.*,
                       ad.nom AS ville_depart,
                       aa.nom AS ville_arrivee,
                       u.nom AS nom_user,
                       u.prenom
                FROM trajets t
                INNER JOIN agences ad ON t.id_agence_depart = ad.id_agence
                INNER JOIN agences aa ON t.id_agence_arrivee = aa.id_agence
                INNER JOIN users u ON t.id_user = u.id_user
                ORDER BY t.date_depart ASC";

        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Recherche un trajet par son identifiant avec infos auteur et agences.
     *
     * @param int $id
     * @return array<string, mixed>|false
     */
    public function findById(int $id): array|false
    {
        $sql = "SELECT t.*,
                       ad.nom AS ville_depart,
                       aa.nom AS ville_arrivee,
                       u.nom AS nom_user,
                       u.prenom,
                       u.telephone,
                       u.email
                FROM trajets t
                INNER JOIN agences ad ON t.id_agence_depart = ad.id_agence
                INNER JOIN agences aa ON t.id_agence_arrivee = aa.id_agence
                INNER JOIN users u ON t.id_user = u.id_user
                WHERE t.id_trajet = :id";

        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Crée un trajet.
     *
     * @param array<string, mixed> $data Données du trajet, y compris id_user.
     * @return bool
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO trajets (
                    id_user,
                    id_agence_depart,
                    id_agence_arrivee,
                    date_depart,
                    date_arrivee,
                    places_totales,
                    places_disponibles
                ) VALUES (
                    :id_user,
                    :id_agence_depart,
                    :id_agence_arrivee,
                    :date_depart,
                    :date_arrivee,
                    :places_totales,
                    :places_disponibles
                )";

        $stmt = $this->getDb()->prepare($sql);

        return $stmt->execute($data);
    }

    /**
     * Met à jour un trajet.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE trajets
                SET id_agence_depart   = :id_agence_depart,
                    id_agence_arrivee  = :id_agence_arrivee,
                    date_depart        = :date_depart,
                    date_arrivee       = :date_arrivee,
                    places_totales     = :places_totales,
                    places_disponibles = :places_disponibles
                WHERE id_trajet = :id";

        $data['id'] = $id;

        $stmt = $this->getDb()->prepare($sql);

        return $stmt->execute($data);
    }

    /**
     * Supprime un trajet.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM trajets WHERE id_trajet = :id';
        $stmt = $this->getDb()->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Retourne le nombre total de trajets (pour le dashboard).
     *
     * @return int
     */
    public function countAll(): int
    {
        $sql = 'SELECT COUNT(*) AS count FROM trajets';
        $stmt = $this->getDb()->query($sql);
        $row = $stmt->fetch();

        return $row !== false ? (int) $row['count'] : 0;
    }
}