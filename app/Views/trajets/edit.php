<?php

declare(strict_types=1);
?>

<h2 class="mb-4">Modifier le trajet</h2>

<?php if (!empty($errors ?? [])): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <form action="/trajets/update/<?= (int) $trajet['id_trajet'] ?>" method="POST" class="card p-4 shadow-sm">
            <fieldset class="mb-3">
                <legend class="fs-6 mb-3">Vos informations</legend>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars((string) ($trajet['nom_user'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" readonly>
                    </div>

                    <div class="col">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars((string) ($trajet['prenom'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars((string) ($trajet['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" readonly>
                    </div>

                    <div class="col">
                        <label class="form-label">Téléphone</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars((string) ($trajet['telephone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" readonly>
                    </div>
                </div>
            </fieldset>

            <hr>

            <fieldset class="mb-3">
                <legend class="fs-6 mb-3">Départ</legend>

                <div class="mb-3">
                    <label class="form-label" for="id_agence_depart">Agence de départ</label>
                    <select id="id_agence_depart" name="id_agence_depart" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($agences as $agence): ?>
                            <option value="<?= (int) $agence['id_agence'] ?>" <?= ((string) ($old['id_agence_depart'] ?? $trajet['id_agence_depart'] ?? '') === (string) $agence['id_agence']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars((string) $agence['nom'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label" for="date_depart">Date de départ</label>
                        <input type="date" id="date_depart" name="date_depart" class="form-control" value="<?= htmlspecialchars((string) ($old['date_depart'] ?? substr((string) ($trajet['date_depart'] ?? ''), 0, 10)), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label" for="heure_depart">Heure de départ</label>
                        <input type="time" id="heure_depart" name="heure_depart" class="form-control" value="<?= htmlspecialchars((string) ($old['heure_depart'] ?? substr((string) ($trajet['date_depart'] ?? ''), 11, 5)), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-3">
                <legend class="fs-6 mb-3">Arrivée</legend>

                <div class="mb-3">
                    <label class="form-label" for="id_agence_arrivee">Agence d'arrivée</label>
                    <select id="id_agence_arrivee" name="id_agence_arrivee" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($agences as $agence): ?>
                            <option value="<?= (int) $agence['id_agence'] ?>" <?= ((string) ($old['id_agence_arrivee'] ?? $trajet['id_agence_arrivee'] ?? '') === (string) $agence['id_agence']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars((string) $agence['nom'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label" for="date_arrivee">Date d'arrivée</label>
                        <input type="date" id="date_arrivee" name="date_arrivee" class="form-control" value="<?= htmlspecialchars((string) ($old['date_arrivee'] ?? substr((string) ($trajet['date_arrivee'] ?? ''), 0, 10)), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label" for="heure_arrivee">Heure d'arrivée</label>
                        <input type="time" id="heure_arrivee" name="heure_arrivee" class="form-control" value="<?= htmlspecialchars((string) ($old['heure_arrivee'] ?? substr((string) ($trajet['date_arrivee'] ?? ''), 11, 5)), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-4">
                <legend class="fs-6 mb-3">Places</legend>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label" for="places_totales">Places totales</label>
                        <input type="number" id="places_totales" name="places_totales" class="form-control" min="1" value="<?= htmlspecialchars((string) ($old['places_totales'] ?? $trajet['places_totales'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label" for="places_disponibles">Places disponibles</label>
                        <input type="number" id="places_disponibles" name="places_disponibles" class="form-control" min="0" value="<?= htmlspecialchars((string) ($old['places_disponibles'] ?? $trajet['places_disponibles'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                </div>
            </fieldset>

            <div class="d-flex justify-content-between">
                <a href="/" class="btn btn-outline-secondary">Annuler</a>
                <button type="submit" class="btn btn-dark">Enregistrer</button>
            </div>
        </form>
    </div>
</div>