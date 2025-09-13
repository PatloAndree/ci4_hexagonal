<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\PageController;
use App\Controllers\UserController;
use Src\admin\user\infrastructure\controllers\GetUserByIdGETControllerci4;
use Src\admin\user\infrastructure\controllers\CreateUserPOSTControllerci4;



/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/pages', [PageController::class, 'index']);

// Rutas “normales” de usuarios (por ejemplo usadas por interfaz web)
$routes->get('/users', [UserController::class, 'index']);
$routes->get('/users/(:num)', [UserController::class, 'show/$1']);
// puedes agregar rutas POST, PUT, DELETE si la web lo requiere

// use Src\admin\user\infrastructure\controllers\GetUserByIdGETController;

$routes->group('api', function($routes) {
    $routes->get('users/(:num)', [GetUserByIdGETControllerci4::class, 'show']);
    $routes->post('users/store', [CreateUserPOSTControllerci4::class, 'create']);


});
