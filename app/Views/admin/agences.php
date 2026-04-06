<h2 class="mb-4">Gestion des agences</h2>

<div class="row mb-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <?php if (!empty($agenceEdit)): ?>
                    <h3 class="h5 mb-3">Modifier une agence</h3>

                    <form action="/admin/agences/update/<?= (int) $agenceEdit['id_agence'] ?>" method="POST">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de l’agence</label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                class="form-control"
                                value="<?= htmlspecialchars($agenceEdit['nom'], ENT_QUOTES, 'UTF-8') ?>"
                                required
                            >
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark">Modifier</button>
                            <a href="/admin/agences" class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </form>
                <?php else: ?>
                    <h3 class="h5 mb-3">Ajouter une agence</h3>

                    <form action="/admin/agences/store" method="POST">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de l’agence</label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                class="form-control"
                                placeholder="Nouvelle agence"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-dark">Ajouter</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($agences)): ?>
                <tr>
                    <td colspan="2" class="text-center">Aucune agence trouvée.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($agences as $agence): ?>
                    <tr>
                        <td><?= htmlspecialchars($agence['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="text-center text-nowrap">
                            <a
                                href="/admin/agences/edit/<?= (int) $agence['id_agence'] ?>"
                                class="btn btn-sm btn-outline-secondary"
                                title="Modifier"
                            >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form
                                action="/admin/agences/delete/<?= (int) $agence['id_agence'] ?>"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Supprimer cette agence ?');"
                            >
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Supprimer"
                                >
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