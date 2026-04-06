<?php

declare(strict_types=1);

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

session_start();

use Buki\Router\Router;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\TrajetController;

$router = new Router();

// Accueil
$router->get('/', function () {
    (new HomeController())->index();
});

// Authentification
$router->get('/login', function () {
    (new AuthController())->loginForm();
});

$router->post('/login', function () {
    (new AuthController())->login();
});

$router->get('/logout', function () {
    (new AuthController())->logout();
});

// Trajets
$router->get('/trajets', function () {
    (new TrajetController())->list();
});

$router->get('/trajets/create', function () {
    (new TrajetController())->create();
});

$router->post('/trajets/store', function () {
    (new TrajetController())->store();
});

$router->get('/trajets/edit/:id', function ($id) {
    (new TrajetController())->edit((int) $id);
});

$router->post('/trajets/update/:id', function ($id) {
    (new TrajetController())->update((int) $id);
});

$router->post('/trajets/delete/:id', function ($id) {
    (new TrajetController())->delete((int) $id);
});

$router->get('/trajets/:id', function ($id) {
    (new TrajetController())->show((int) $id);
});

// Admin
$router->get('/admin', function () {
    (new AdminController())->dashboard();
});

$router->get('/admin/users', function () {
    (new AdminController())->users();
});

$router->get('/admin/agences', function () {
    (new AdminController())->agences();
});

$router->post('/admin/agences/store', function () {
    (new AdminController())->agenceStore();
});

$router->get('/admin/agences/edit/:id', function ($id) {
    (new AdminController())->agenceEdit((int) $id);
});

$router->post('/admin/agences/update/:id', function ($id) {
    (new AdminController())->agenceUpdate((int) $id);
});

$router->post('/admin/agences/delete/:id', function ($id) {
    (new AdminController())->agenceDelete((int) $id);
});

$router->get('/admin/trajets', function () {
    (new AdminController())->trajets();
});

$router->post('/admin/trajets/delete/:id', function ($id) {
    (new AdminController())->trajetDelete((int) $id);
});

try {
    $router->run();
} catch (Throwable $e) {
    echo '<pre>';
    echo 'Message : ' . $e->getMessage() . "\n";
    echo 'Fichier : ' . $e->getFile() . "\n";
    echo 'Ligne   : ' . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
    echo '</pre>';
}