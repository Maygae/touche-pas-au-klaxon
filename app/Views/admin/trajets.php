<h2 class="mb-4">Gestion des trajets</h2>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle mt-4">
        <thead class="table-light">
            <tr>
                <th>Départ</th>
                <th>Date départ</th>
                <th>Destination</th>
                <th>Date arrivée</th>
                <th>Auteur</th>
                <th>Places</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($trajets)): ?>
                <tr>
                    <td colspan="7" class="text-center">Aucun trajet trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($trajets as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['ville_depart'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($trajet['date_depart'])) ?></td>
                        <td><?= htmlspecialchars($trajet['ville_arrivee'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($trajet['date_arrivee'])) ?></td>
                        <td><?= htmlspecialchars($trajet['prenom'] . ' ' . $trajet['nom_user'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= (int) $trajet['places_disponibles'] ?>/<?= (int) $trajet['places_totales'] ?></td>
                        <td class="text-center">
                            <form
                                action="/admin/trajets/delete/<?= (int) $trajet['id_trajet'] ?>"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Supprimer ce trajet ?');"
                            >
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>