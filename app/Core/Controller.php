<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Classe parente des contrôleurs.
 *
 * Fournit les méthodes utilitaires communes :
 * - affichage d'une vue avec layout ;
 * - redirection HTTP.
 */
class Controller
{
    /**
     * Affiche une vue avec le layout principal.
     *
     * @param string $view Nom de la vue sans extension, par exemple "home/index".
     * @param array<string, mixed> $data Données transmises à la vue.
     * @return void
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $viewFile = VIEW_PATH . '/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(404);
            echo 'Vue introuvable.';
            return;
        }

        require VIEW_PATH . '/layouts/header.php';
        require $viewFile;
        require VIEW_PATH . '/layouts/footer.php';
    }

    /**
     * Redirige vers une URL.
     *
     * @param string $path Chemin de redirection.
     * @return never
     */
    protected function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }
}