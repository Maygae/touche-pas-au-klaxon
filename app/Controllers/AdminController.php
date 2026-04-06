<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Agence;
use App\Models\Trajet;
use App\Models\Utilisateur;

/**
 * Contrôleur de l'administration.
 */
class AdminController extends Controller
{
    /**
     * Vérifie que l'utilisateur connecté est administrateur.
     *
     * @return void
     */
    private function requireAdmin(): void
    {
        if (!Session::isAdmin()) {
            Session::setFlash('Accès refusé.');
            header('Location: /login');
            exit;
        }
    }

    /**
     * Point d'entrée de l'espace administrateur.
     *
     * @return void
     */
    public function dashboard(): void
    {
        $this->requireAdmin();

        header('Location: /admin/trajets');
        exit;
    }

    /**
     * Affiche la liste des utilisateurs.
     *
     * @return void
     */
    public function users(): void
    {
        $this->requireAdmin();

        $userModel = new Utilisateur();
        $users = $userModel->getAll();

        $this->render('admin/users', [
            'users' => $users,
        ]);
    }

    /**
     * Affiche la liste des agences et le formulaire d'ajout.
     *
     * @return void
     */
    public function agences(): void
    {
        $this->requireAdmin();

        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();

        $this->render('admin/agences', [
            'agences' => $agences,
            'agenceEdit' => null,
        ]);
    }

    /**
     * Enregistre une nouvelle agence.
     *
     * @return void
     */
    public function agenceStore(): void
    {
        $this->requireAdmin();

        $nom = trim($_POST['nom'] ?? '');

        if ($nom === '') {
            Session::setFlash("Le nom de l'agence est obligatoire.");
            header('Location: /admin/agences');
            exit;
        }

        $agenceModel = new Agence();
        $success = $agenceModel->create($nom);

        Session::setFlash(
            $success
                ? 'Agence créée avec succès.'
                : "Erreur lors de la création de l'agence."
        );

        header('Location: /admin/agences');
        exit;
    }

    /**
     * Affiche la liste des agences avec une agence en mode édition.
     *
     * @param int $id
     * @return void
     */
    public function agenceEdit(int $id): void
    {
        $this->requireAdmin();

        $agenceModel = new Agence();
        $agence = $agenceModel->findById($id);

        if ($agence === false) {
            Session::setFlash('Agence introuvable.');
            header('Location: /admin/agences');
            exit;
        }

        $agences = $agenceModel->getAll();

        $this->render('admin/agences', [
            'agences' => $agences,
            'agenceEdit' => $agence,
        ]);
    }

    /**
     * Met à jour une agence.
     *
     * @param int $id
     * @return void
     */
    public function agenceUpdate(int $id): void
    {
        $this->requireAdmin();

        $nom = trim($_POST['nom'] ?? '');

        if ($nom === '') {
            Session::setFlash("Le nom de l'agence est obligatoire.");
            header('Location: /admin/agences/edit/' . $id);
            exit;
        }

        $agenceModel = new Agence();
        $agence = $agenceModel->findById($id);

        if ($agence === false) {
            Session::setFlash('Agence introuvable.');
            header('Location: /admin/agences');
            exit;
        }

        $success = $agenceModel->update($id, $nom);

        Session::setFlash(
            $success
                ? 'Agence modifiée avec succès.'
                : "Erreur lors de la modification de l'agence."
        );

        header('Location: /admin/agences');
        exit;
    }

    /**
     * Supprime une agence.
     *
     * @param int $id
     * @return void
     */
    public function agenceDelete(int $id): void
    {
        $this->requireAdmin();

        $agenceModel = new Agence();
        $agence = $agenceModel->findById($id);

        if ($agence === false) {
            Session::setFlash('Agence introuvable.');
            header('Location: /admin/agences');
            exit;
        }

        $success = $agenceModel->delete($id);

        Session::setFlash(
            $success
                ? 'Agence supprimée avec succès.'
                : "Erreur lors de la suppression de l'agence."
        );

        header('Location: /admin/agences');
        exit;
    }

    /**
     * Affiche la liste de tous les trajets.
     *
     * @return void
     */
    public function trajets(): void
    {
        $this->requireAdmin();

        $trajetModel = new Trajet();
        $trajets = $trajetModel->getAll();

        $this->render('admin/trajets', [
            'trajets' => $trajets,
        ]);
    }

    /**
     * Supprime un trajet.
     *
     * @param int $id
     * @return void
     */
    public function trajetDelete(int $id): void
    {
        $this->requireAdmin();

        $trajetModel = new Trajet();
        $trajet = $trajetModel->findById($id);

        if ($trajet === false) {
            Session::setFlash('Trajet introuvable.');
            header('Location: /admin/trajets');
            exit;
        }

        $success = $trajetModel->delete($id);

        Session::setFlash(
            $success
                ? 'Trajet supprimé avec succès.'
                : 'Erreur lors de la suppression du trajet.'
        );

        header('Location: /admin/trajets');
        exit;
    }
}