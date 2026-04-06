<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Classe parente des modèles.
 *
 * Fournit une connexion PDO partagée à la base de données.
 */
class Model
{
    /**
     * Connexion PDO partagée entre toutes les instances de modèles.
     *
     * @var PDO|null
     */
    protected static ?PDO $pdo = null;

    /**
     * Retourne la connexion à la base de données.
     *
     * @throws RuntimeException Si la connexion échoue.
     * @return PDO
     */
    protected function getDb(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=' . DB_HOST .
                    ';port=' . DB_PORT .
                    ';dbname=' . DB_NAME .
                    ';charset=' . DB_CHARSET,
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                // Utile en développement pour comprendre la cause.
                error_log('Erreur PDO : ' . $e->getMessage());
                throw new RuntimeException('Connexion à la base de données impossible.');
            }
        }

        return self::$pdo;
    }
}