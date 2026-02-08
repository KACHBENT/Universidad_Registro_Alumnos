<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*

*/

// =========================
// INICIO
// =========================
$routes->get(
    '/',
    'Home::index'
);


// =========================
// ALUMNOS
// =========================
$routes->group('alumnos', ['filter' => 'csrf'], static function ($routes) {

    $routes->get(
        '/',
        'AlumnoController::index'
    );

    $routes->get(
        'create',
        'AlumnoController::create'
    );

    $routes->post(
        'store',
        'AlumnoController::store'
    );

    $routes->get(
        'edit/(:num)',
        'AlumnoController::edit/$1'
    );

    $routes->post(
        'update/(:num)',
        'AlumnoController::update/$1'
    );

    $routes->get(
        'delete/(:num)',
        'AlumnoController::delete/$1'
    );

    $routes->get(
        'activar/(:num)',
        'AlumnoController::activar/$1'
    );
});


// =========================
// CARRERAS
// =========================
$routes->group('categorias/carreras', ['filter' => 'csrf'], static function ($routes) {

    $routes->get(
        '/',
        'CarrerasController::index'
    );

    $routes->get(
        'create',
        'CarrerasController::create'
    );

    $routes->post(
        'store',
        'CarrerasController::store'
    );

    $routes->get(
        'edit/(:num)',
        'CarrerasController::edit/$1'
    );

    $routes->post(
        'update/(:num)',
        'CarrerasController::update/$1'
    );

    $routes->get(
        'delete/(:num)',
        'CarrerasController::delete/$1'
    );

    $routes->get(
        'activar/(:num)',
        'CarrerasController::activar/$1'
    );
});


// =========================
// TURNOS
// =========================
$routes->group('categorias/turnos', ['filter' => 'csrf'], static function ($routes) {

    $routes->get(
        '/',
        'TurnosController::index'
    );

    $routes->get(
        'create',
        'TurnosController::create'
    );

    $routes->post(
        'store',
        'TurnosController::store'
    );

    $routes->get(
        'edit/(:num)',
        'TurnosController::edit/$1'
    );

    $routes->post(
        'update/(:num)',
        'TurnosController::update/$1'
    );

    $routes->get(
        'delete/(:num)',
        'TurnosController::delete/$1'
    );

    $routes->get(
        'activar/(:num)',
        'TurnosController::activar/$1'
    );
});


// =========================
// GRUPOS
// =========================
$routes->group('operaciones/grupos', ['filter' => 'csrf'], static function ($routes) {

    $routes->get(
        '/',
        'GruposController::index'
    );

    $routes->get(
        'create',
        'GruposController::create'
    );

    $routes->post(
        'store',
        'GruposController::store'
    );

    $routes->get(
        'edit/(:num)',
        'GruposController::edit/$1'
    );

    $routes->post(
        'update/(:num)',
        'GruposController::update/$1'
    );

    $routes->get(
        'delete/(:num)',
        'GruposController::delete/$1'
    );

    $routes->get(
        'activar/(:num)',
        'GruposController::activar/$1'
    );
});



