<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Utilisateur;

/**
 * Contrôleur d'authentification.
 *
 * Gère :
 * - l'affichage du formulaire de connexion ;
 * - la tentative de connexion ;
 * - la déconnexion.
 */
class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     *
     * @return void
     */
    public function loginForm(): void
    {
        if (Session::isLogged()) {
            $this->redirect('/');
        }

        $this->render('auth/login');
    }

    /**
     * Traite la connexion de l'utilisateur.
     *
     * @return void
     */
    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $this->render('auth/login', [
                'error' => 'Veuillez remplir tous les champs.',
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('auth/login', [
                'error' => 'Adresse email invalide.',
            ]);
            return;
        }

        $userModel = new Utilisateur();
        $user = $userModel->findByEmail($email);

        if ($user !== false && password_verify($password, $user['mot_de_passe'])) {
            Session::login($user);
            Session::setFlash('Connexion réussie.');
            $this->redirect('/');
            return;
        }

        $this->render('auth/login', [
            'error' => 'Email ou mot de passe incorrect.',
        ]);
    }

    /**
     * Déconnecte l'utilisateur.
     *
     * @return void
     */
    public function logout(): void
    {
        if (Session::isLogged()) {
            Session::logout();
            Session::setFlash('Vous avez été déconnecté.');
        }

        $this->redirect('/');
    }
}