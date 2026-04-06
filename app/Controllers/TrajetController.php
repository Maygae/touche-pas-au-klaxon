<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Agence;
use App\Models\Trajet;
use Throwable;

/**
 * Contrôleur de gestion des trajets.
 */
class TrajetController extends Controller
{
    /**
     * Vérifie qu'un utilisateur est connecté.
     */
    private function checkLogged(): void
    {
        if (!Session::isLogged()) {
            $this->redirect('/login');
        }
    }

    /**
     * Vérifie si l'utilisateur connecté peut gérer le trajet.
     *
     * @param array<string, mixed> $trajet
     */
    private function canManage(array $trajet): bool
    {
        $user = Session::getUser();

        if ($user === null) {
            return false;
        }

        if (Session::isAdmin()) {
            return true;
        }

        return isset($user['id_user'], $trajet['id_user'])
            && (int) $user['id_user'] === (int) $trajet['id_user'];
    }

    /**
     * Liste des trajets (page d'accueil utilisateur connecté).
     */
    public function list(): void
    {
        $this->checkLogged();

        $trajetModel = new Trajet();
        $trajets = $trajetModel->getAvailable();

        $this->render('home/index', [
            'trajets' => $trajets,
        ]);
    }

    /**
     * Affiche le formulaire de création d'un trajet.
     */
    public function create(): void
    {
        $this->checkLogged();

        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();

        $this->render('trajets/create', [
            'agences' => $agences,
            'user'    => Session::getUser(),
            'errors'  => [],
            'old'     => [],
        ]);
    }

    /**
     * Enregistre un nouveau trajet.
     */
    public function store(): void
    {
        $this->checkLogged();

        $user        = Session::getUser();
        $agenceModel = new Agence();
        $agences     = $agenceModel->getAll();

        $dateDepart  = trim((string) ($_POST['date_depart'] ?? ''));
        $heureDepart = trim((string) ($_POST['heure_depart'] ?? ''));
        $dateArrivee = trim((string) ($_POST['date_arrivee'] ?? ''));
        $heureArrivee = trim((string) ($_POST['heure_arrivee'] ?? ''));

        $data = [
            'id_user'           => (int) ($user['id_user'] ?? 0),
            'id_agence_depart'  => (int) ($_POST['id_agence_depart'] ?? 0),
            'id_agence_arrivee' => (int) ($_POST['id_agence_arrivee'] ?? 0),
            'date_depart'       => ($dateDepart !== '' && $heureDepart !== '') ? $dateDepart . ' ' . $heureDepart . ':00' : '',
            'date_arrivee'      => ($dateArrivee !== '' && $heureArrivee !== '') ? $dateArrivee . ' ' . $heureArrivee . ':00' : '',
            'places_totales'    => (int) ($_POST['places_totales'] ?? 0),
            'places_disponibles'=> (int) ($_POST['places_disponibles'] ?? 0),
        ];

        $errors = $this->validateTripData($data);

        if (!empty($errors)) {
            $this->render('trajets/create', [
                'agences' => $agences,
                'user'    => $user,
                'errors'  => $errors,
                'old'     => [
                    'id_agence_depart'  => $_POST['id_agence_depart'] ?? '',
                    'id_agence_arrivee' => $_POST['id_agence_arrivee'] ?? '',
                    'date_depart'       => $dateDepart,
                    'heure_depart'      => $heureDepart,
                    'date_arrivee'      => $dateArrivee,
                    'heure_arrivee'     => $heureArrivee,
                    'places_totales'    => $_POST['places_totales'] ?? '',
                    'places_disponibles'=> $_POST['places_disponibles'] ?? '',
                ],
            ]);
            return;
        }

        try {
            $trajetModel = new Trajet();
            $trajetModel->create($data);

            Session::setFlash('Le trajet a été créé.');
            $this->redirect('/');
        } catch (Throwable) {
            $this->render('trajets/create', [
                'agences' => $agences,
                'user'    => $user,
                'errors'  => ['Une erreur est survenue lors de la création du trajet.'],
                'old'     => [
                    'id_agence_depart'  => $_POST['id_agence_depart'] ?? '',
                    'id_agence_arrivee' => $_POST['id_agence_arrivee'] ?? '',
                    'date_depart'       => $dateDepart,
                    'heure_depart'      => $heureDepart,
                    'date_arrivee'      => $dateArrivee,
                    'heure_arrivee'     => $heureArrivee,
                    'places_totales'    => $_POST['places_totales'] ?? '',
                    'places_disponibles'=> $_POST['places_disponibles'] ?? '',
                ],
            ]);
        }
    }

    /**
     * Affiche le formulaire d'édition d'un trajet.
     */
    public function edit(int $id): void
    {
        $this->checkLogged();

        $trajetModel = new Trajet();
        $trajet = $trajetModel->findById($id);

        if ($trajet === false || !$this->canManage($trajet)) {
            Session::setFlash('Vous ne pouvez pas modifier ce trajet.');
            $this->redirect('/');
        }

        $agenceModel = new Agence();
        $agences     = $agenceModel->getAll();

        $dateDepart  = '';
        $heureDepart = '';
        if (!empty($trajet['date_depart'])) {
            [$dateDepart, $heureDepart] = explode(' ', (string) $trajet['date_depart']);
            $heureDepart = substr($heureDepart, 0, 5);
        }

        $dateArrivee  = '';
        $heureArrivee = '';
        if (!empty($trajet['date_arrivee'])) {
            [$dateArrivee, $heureArrivee] = explode(' ', (string) $trajet['date_arrivee']);
            $heureArrivee = substr($heureArrivee, 0, 5);
        }

        $this->render('trajets/edit', [
            'trajet'  => $trajet,
            'agences' => $agences,
            'errors'  => [],
            'old'     => [
                'id_agence_depart'  => $trajet['id_agence_depart'] ?? '',
                'id_agence_arrivee' => $trajet['id_agence_arrivee'] ?? '',
                'date_depart'       => $dateDepart,
                'heure_depart'      => $heureDepart,
                'date_arrivee'      => $dateArrivee,
                'heure_arrivee'     => $heureArrivee,
                'places_totales'    => $trajet['places_totales'] ?? '',
                'places_disponibles'=> $trajet['places_disponibles'] ?? '',
            ],
        ]);
    }

    /**
     * Met à jour un trajet.
     */
    public function update(int $id): void
    {
        $this->checkLogged();

        $trajetModel = new Trajet();
        $trajet = $trajetModel->findById($id);

        if ($trajet === false || !$this->canManage($trajet)) {
            Session::setFlash('Vous ne pouvez pas modifier ce trajet.');
            $this->redirect('/');
        }

        $agenceModel = new Agence();
        $agences     = $agenceModel->getAll();

        $dateDepart  = trim((string) ($_POST['date_depart'] ?? ''));
        $heureDepart = trim((string) ($_POST['heure_depart'] ?? ''));
        $dateArrivee = trim((string) ($_POST['date_arrivee'] ?? ''));
        $heureArrivee = trim((string) ($_POST['heure_arrivee'] ?? ''));

        $data = [
            'id_agence_depart'  => (int) ($_POST['id_agence_depart'] ?? 0),
            'id_agence_arrivee' => (int) ($_POST['id_agence_arrivee'] ?? 0),
            'date_depart'       => ($dateDepart !== '' && $heureDepart !== '') ? $dateDepart . ' ' . $heureDepart . ':00' : '',
            'date_arrivee'      => ($dateArrivee !== '' && $heureArrivee !== '') ? $dateArrivee . ' ' . $heureArrivee . ':00' : '',
            'places_totales'    => (int) ($_POST['places_totales'] ?? 0),
            'places_disponibles'=> (int) ($_POST['places_disponibles'] ?? 0),
        ];

        $errors = $this->validateTripData($data);

        if (!empty($errors)) {
            $this->render('trajets/edit', [
                'trajet'  => $trajet,
                'agences' => $agences,
                'errors'  => $errors,
                'old'     => [
                    'id_agence_depart'  => $_POST['id_agence_depart'] ?? '',
                    'id_agence_arrivee' => $_POST['id_agence_arrivee'] ?? '',
                    'date_depart'       => $dateDepart,
                    'heure_depart'      => $heureDepart,
                    'date_arrivee'      => $dateArrivee,
                    'heure_arrivee'     => $heureArrivee,
                    'places_totales'    => $_POST['places_totales'] ?? '',
                    'places_disponibles'=> $_POST['places_disponibles'] ?? '',
                ],
            ]);
            return;
        }

        try {
            $trajetModel->update($id, $data);
            Session::setFlash('Le trajet a été modifié.');
            $this->redirect('/');
        } catch (Throwable) {
            $this->render('trajets/edit', [
                'trajet'  => $trajet,
                'agences' => $agences,
                'errors'  => ['Une erreur est survenue lors de la modification du trajet.'],
                'old'     => [
                    'id_agence_depart'  => $_POST['id_agence_depart'] ?? '',
                    'id_agence_arrivee' => $_POST['id_agence_arrivee'] ?? '',
                    'date_depart'       => $dateDepart,
                    'heure_depart'      => $heureDepart,
                    'date_arrivee'      => $dateArrivee,
                    'heure_arrivee'     => $heureArrivee,
                    'places_totales'    => $_POST['places_totales'] ?? '',
                    'places_disponibles'=> $_POST['places_disponibles'] ?? '',
                ],
            ]);
        }
    }

    /**
     * Supprime un trajet.
     */
    public function delete(int $id): void
    {
        $this->checkLogged();

        $trajetModel = new Trajet();
        $trajet = $trajetModel->findById($id);

        if ($trajet === false || !$this->canManage($trajet)) {
            Session::setFlash('Vous ne pouvez pas supprimer ce trajet.');
            $this->redirect('/');
        }

        try {
            $trajetModel->delete($id);
            Session::setFlash('Le trajet a été supprimé.');
        } catch (Throwable) {
            Session::setFlash('Erreur lors de la suppression du trajet.');
        }

        $this->redirect('/');
    }

    /**
     * Affiche un trajet individuel (optionnel).
     */
    public function show(int $id): void
    {
        $this->checkLogged();

        $trajetModel = new Trajet();
        $trajet = $trajetModel->findById($id);

        if ($trajet === false) {
            http_response_code(404);
            echo 'Trajet introuvable.';
            return;
        }

        $this->render('trajets/show', [
            'trajet' => $trajet,
        ]);
    }

    /**
     * Vérifie la cohérence des données d'un trajet.
     *
     * @param array<string, mixed> $data
     * @return string[]
     */
    private function validateTripData(array $data): array
    {
        $errors = [];

        if ((int) ($data['id_agence_depart'] ?? 0) <= 0 || (int) ($data['id_agence_arrivee'] ?? 0) <= 0) {
            $errors[] = 'Veuillez sélectionner une agence de départ et une agence d’arrivée.';
        }

        if ((int) ($data['id_agence_depart'] ?? 0) === (int) ($data['id_agence_arrivee'] ?? 0)) {
            $errors[] = 'L’agence de départ et l’agence d’arrivée doivent être différentes.';
        }

        if (($data['date_depart'] ?? '') === '' || ($data['date_arrivee'] ?? '') === '') {
            $errors[] = 'Les dates et heures de départ et d’arrivée sont obligatoires.';
        } else {
            $departureTimestamp = strtotime((string) $data['date_depart']);
            $arrivalTimestamp   = strtotime((string) $data['date_arrivee']);

            if ($departureTimestamp === false || $arrivalTimestamp === false) {
                $errors[] = 'Les dates saisies sont invalides.';
            } elseif ($arrivalTimestamp <= $departureTimestamp) {
                $errors[] = 'On ne peut pas arriver avant de partir.';
            }
        }

        if ((int) ($data['places_totales'] ?? 0) <= 0) {
            $errors[] = 'Le nombre total de places doit être supérieur à zéro.';
        }

        if ((int) ($data['places_disponibles'] ?? 0) < 0) {
            $errors[] = 'Le nombre de places disponibles ne peut pas être négatif.';
        }

        if ((int) ($data['places_disponibles'] ?? 0) > (int) ($data['places_totales'] ?? 0)) {
            $errors[] = 'Le nombre de places disponibles ne peut pas dépasser le nombre total de places.';
        }

        return $errors;
    }
}