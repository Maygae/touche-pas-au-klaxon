<h2>Liste des utilisateurs</h2>

<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Rôle</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($users)): ?>
            <tr>
                <td colspan="5" class="text-center">Aucun utilisateur trouvé.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['prenom'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['telephone'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?= ($user['role'] ?? 'user') === 'admin' ? 'Administrateur' : 'Utilisateur' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>