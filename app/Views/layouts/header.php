<?php

declare(strict_types=1);

use App\Core\Session;

$user = Session::getUser();
$isLogged = Session::isLogged();
$isAdmin = Session::isAdmin();

$brandLink = $isAdmin ? '/admin' : '/';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= $brandLink ?>">
            Touche pas au klaxon
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Afficher la navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <?php if ($isAdmin): ?>
                <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-2 ms-auto">
                    <span class="badge text-bg-dark">Admin</span>
                    <a href="/admin/users" class="btn btn-outline-secondary btn-sm">Utilisateurs</a>
                    <a href="/admin/agences" class="btn btn-outline-secondary btn-sm">Agences</a>
                    <a href="/admin/trajets" class="btn btn-outline-secondary btn-sm">Trajets</a>
                    <a href="/logout" class="btn btn-dark btn-sm">Déconnexion</a>
                </div>

            <?php elseif ($isLogged): ?>
                <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-2 ms-auto">
                    <a href="/trajets/create" class="btn btn-dark btn-sm">Créer un trajet</a>

                    <span class="px-2">
                        <?= htmlspecialchars($user['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        <?= htmlspecialchars($user['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <a href="/logout" class="btn btn-outline-dark btn-sm">Déconnexion</a>
                </div>

            <?php else: ?>
                <div class="d-flex ms-auto">
                    <a href="/login" class="btn btn-dark btn-sm">Connexion</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php $flash = Session::getFlash(); ?>
<?php if ($flash): ?>
    <div class="container mt-3">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Fermer"
            ></button>
        </div>
    </div>
<?php endif; ?>

<main class="container py-4">