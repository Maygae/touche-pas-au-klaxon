<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Gestion simplifiée de la session.
 */
class Session
{
    /**
     * Enregistre l'utilisateur connecté en session.
     *
     * @param array<string, mixed> $user
     * @return void
     */
    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
    }

    /**
     * Déconnecte l'utilisateur.
     *
     * @return void
     */
    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    /**
     * Retourne l'utilisateur connecté.
     *
     * @return array<string, mixed>|null
     */
    public static function getUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Vérifie si un utilisateur est connecté.
     *
     * @return bool
     */
    public static function isLogged(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Vérifie si l'utilisateur connecté est administrateur.
     *
     * @return bool
     */
    public static function isAdmin(): bool
    {
        if (!self::isLogged()) {
            return false;
        }

        $user = self::getUser();

        return ($user['role'] ?? '') === 'admin';
    }

    /**
     * Définit un message flash.
     *
     * @param string $message
     * @return void
     */
    public static function setFlash(string $message): void
    {
        $_SESSION['flash'] = $message;
    }

    /**
     * Retourne puis supprime le message flash.
     *
     * @return string|null
     */
    public static function getFlash(): ?string
    {
        if (!isset($_SESSION['flash'])) {
            return null;
        }

        $message = (string) $_SESSION['flash'];
        unset($_SESSION['flash']);

        return $message;
    }
}