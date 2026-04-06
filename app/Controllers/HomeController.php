<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Trajet;

/**
 * Contrôleur de la page d'accueil.
 *
 * L'accueil affiche la liste des trajets futurs
 * pour lesquels il reste des places disponibles.
 */
class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil.
     *
     * @return void
     */
    public function index(): void
    {
        $trajetModel = new Trajet();

        $trajets = $trajetModel->getAvailable();

        $this->render('home/index', [
            'trajets' => $trajets,
        ]);
    }
}