<?php

declare(strict_types=1);

use App\Core\Session;

$user = Session::getUser();
?>

<?php if (!Session::isLogged()): ?>
    <h2 class="mb-4">Pour obtenir plus d’informations sur un trajet, veuillez vous connecter</h2>
<?php else: ?>
    <h2 class="mb-4">Trajets proposés</h2>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle mt-4">
        <thead class="table-light">
            <tr>
                <th>Départ</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places</th>
                <?php if (Session::isLogged()): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($trajets ?? [])): ?>
                <tr>
                    <td colspan="<?= Session::isLogged() ? '8' : '7' ?>" class="text-center">
                        Aucun trajet disponible.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($trajets as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $trajet['ville_depart'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime((string) $trajet['date_depart'])), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars(date('H:i', strtotime((string) $trajet['date_depart'])), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $trajet['ville_arrivee'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime((string) $trajet['date_arrivee'])), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars(date('H:i', strtotime((string) $trajet['date_arrivee'])), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= (int) $trajet['places_disponibles'] ?></td>

                        <?php if (Session::isLogged()): ?>
                            <td class="text-nowrap">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-<?= (int) $trajet['id_trajet'] ?>"
                                    title="Voir les détails"
                                    aria-label="Voir les détails du trajet"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                                <?php
                                $isAuthor = $user !== null
                                    && isset($user['id_user'], $trajet['id_user'])
                                    && (int) $user['id_user'] === (int) $trajet['id_user'];
                                ?>

                                <?php if ($isAuthor || Session::isAdmin()): ?>
                                    <a
                                        href="/trajets/edit/<?= (int) $trajet['id_trajet'] ?>"
                                        class="btn btn-sm btn-outline-secondary"
                                        title="Modifier"
                                        aria-label="Modifier le trajet"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form
                                        action="/trajets/delete/<?= (int) $trajet['id_trajet'] ?>"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Supprimer ce trajet ?');"
                                    >
                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Supprimer"
                                            aria-label="Supprimer le trajet"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (Session::isLogged() && !empty($trajets ?? [])): ?>
    <?php foreach ($trajets as $trajet): ?>
        <div
            class="modal fade"
            id="modal-<?= (int) $trajet['id_trajet'] ?>"
            tabindex="-1"
            aria-labelledby="modalLabel-<?= (int) $trajet['id_trajet'] ?>"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel-<?= (int) $trajet['id_trajet'] ?>">
                            Détails du trajet
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fermer"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <p>
                            Auteur :
                            <strong>
                                <?= htmlspecialchars((string) $trajet['prenom'] . ' ' . (string) $trajet['nom_user'], ENT_QUOTES, 'UTF-8') ?>
                            </strong>
                        </p>
                        <p>
                            Téléphone :
                            <strong><?= htmlspecialchars((string) $trajet['telephone'], ENT_QUOTES, 'UTF-8') ?></strong>
                        </p>
                        <p>
                            Email :
                            <strong><?= htmlspecialchars((string) $trajet['email'], ENT_QUOTES, 'UTF-8') ?></strong>
                        </p>
                        <p>
                            Nombre total de places :
                            <strong><?= (int) $trajet['places_totales'] ?></strong>
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>