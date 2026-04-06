<?php

use PHPUnit\Framework\TestCase;
use App\Models\Trajet;

/**
 * Tests unitaires / d'intégration pour le modèle Trajet
 *
 * Couvre les opérations d'écriture en base de données :
 * création, modification et suppression.
 */
class TrajetTest extends TestCase
{
    private Trajet $trajetModel;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../config/config.php';
        $this->trajetModel = new Trajet();
    }

    /**
     * Crée un trajet de test et retourne son identifiant.
     */
    private function createTestTrajet(): int
    {
        $trajetsAvant = $this->trajetModel->getAll();
        $idsAvant = array_column($trajetsAvant, 'id_trajet');

        $result = $this->trajetModel->create([
            'id_user' => 1,
            'id_agence_depart' => 1,
            'id_agence_arrivee' => 2,
            'date_depart' => '2026-12-10 08:00:00',
            'date_arrivee' => '2026-12-10 12:00:00',
            'places_totales' => 4,
            'places_disponibles' => 3
        ]);

        $this->assertTrue($result);

        $trajetsApres = $this->trajetModel->getAll();

        foreach ($trajetsApres as $trajet) {
            if (!in_array($trajet['id_trajet'], $idsAvant, true)) {
                return (int) $trajet['id_trajet'];
            }
        }

        $this->fail('Impossible de retrouver le trajet créé.');
    }

    /**
     * Test de création d'un trajet.
     */
    public function testCreateTrajet(): void
    {
        $trajetsAvant = $this->trajetModel->getAll();
        $nbAvant = count($trajetsAvant);

        $result = $this->trajetModel->create([
            'id_user' => 1,
            'id_agence_depart' => 1,
            'id_agence_arrivee' => 2,
            'date_depart' => '2026-12-01 08:00:00',
            'date_arrivee' => '2026-12-01 12:00:00',
            'places_totales' => 4,
            'places_disponibles' => 3
        ]);

        $this->assertTrue($result);

        $trajetsApres = $this->trajetModel->getAll();
        $nbApres = count($trajetsApres);

        $this->assertSame($nbAvant + 1, $nbApres);
    }

    /**
     * Test de modification d'un trajet.
     */
    public function testUpdateTrajet(): void
    {
        $idTrajet = $this->createTestTrajet();

        $result = $this->trajetModel->update($idTrajet, [
            'id_agence_depart' => 3,
            'id_agence_arrivee' => 4,
            'date_depart' => '2026-12-12 09:00:00',
            'date_arrivee' => '2026-12-12 13:00:00',
            'places_totales' => 5,
            'places_disponibles' => 4
        ]);

        $this->assertTrue($result);

        $trajets = $this->trajetModel->getAll();
        $trajetModifie = null;

        foreach ($trajets as $trajet) {
            if ((int) $trajet['id_trajet'] === $idTrajet) {
                $trajetModifie = $trajet;
                break;
            }
        }

        $this->assertNotNull($trajetModifie);
        $this->assertSame(3, (int) $trajetModifie['id_agence_depart']);
        $this->assertSame(4, (int) $trajetModifie['id_agence_arrivee']);
        $this->assertSame(5, (int) $trajetModifie['places_totales']);
        $this->assertSame(4, (int) $trajetModifie['places_disponibles']);
    }

    /**
     * Test de suppression d'un trajet.
     */
    public function testDeleteTrajet(): void
    {
        $idTrajet = $this->createTestTrajet();

        $result = $this->trajetModel->delete($idTrajet);

        $this->assertTrue($result);

        $trajets = $this->trajetModel->getAll();
        $ids = array_column($trajets, 'id_trajet');

        $this->assertNotContains($idTrajet, array_map('intval', $ids));
    }

    /**
     * Test que getAvailable retourne uniquement les trajets futurs avec places.
     */
    public function testGetAvailableReturnsFutureOnly(): void
    {
        $trajets = $this->trajetModel->getAvailable();

        foreach ($trajets as $trajet) {
            $this->assertGreaterThan(date('Y-m-d H:i:s'), $trajet['date_depart']);
            $this->assertGreaterThan(0, (int) $trajet['places_disponibles']);
        }
    }
}