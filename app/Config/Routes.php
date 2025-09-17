<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\PageController;
use App\Controllers\UserController;
use Src\admin\user\infrastructure\controllers\GetUserByIdGETControllerci4;
use Src\admin\user\infrastructure\controllers\CreateUserPOSTControllerci4;



/**
 * @var RouteCollection $routes
 */

// $routes->get('/', 'Home::index');
$routes->get('/', [PageController::class, 'index']);

$routes->get('pages/usuarios', [PageController::class, 'usuarios']);
$routes->get('pages/usuarios/list', [UserController::class, 'usuariosList']);
$routes->get('pages/usuarios/editar/(:num)', [UserController::class, 'getUsuario']);  // para obtener data para el modal
$routes->post('pages/usuarios/guardar', [UserController::class, 'guardarUsuario']);    // para guardar o editar
$routes->post('pages/usuarios/eliminar', [UserController::class, 'eliminarUsuario']); 


$routes->get('pages/vehiculos', [PageController::class, 'vehiculos']);


// Rutas “normales” de usuarios (por ejemplo usadas por interfaz web)
// $routes->get('/users', [UserController::class, 'index']);
// $routes->get('/users/(:num)', [UserController::class, 'show/$1']);

// use Src\admin\user\infrastructure\controllers\GetUserByIdGETController;

$routes->group('api', function($routes) {
    $routes->get('users/(:num)', [GetUserByIdGETControllerci4::class, 'show']);
    $routes->post('users/store', [CreateUserPOSTControllerci4::class, 'create']);


});
