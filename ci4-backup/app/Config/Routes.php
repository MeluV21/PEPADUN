<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Root URL redirects to dashboard (which triggers auth check)
$routes->get('/', function() {
    return redirect()->to('/dashboard');
});

// Authentication Routes
$routes->match(['get', 'post'], 'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Authenticated Routes (Protected by AuthFilter)
$routes->group('', ['filter' => 'auth'], function(RouteCollection $routes) {
    
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Monitoring CRUD (Access checked in controller logic for ownership)
    $routes->group('monitoring', function(RouteCollection $routes) {
        $routes->get('/', 'Monitoring::index');
        $routes->get('create', 'Monitoring::create');
        $routes->post('store', 'Monitoring::store');
        $routes->get('edit/(:num)', 'Monitoring::edit/$1');
        $routes->post('update/(:num)', 'Monitoring::update/$1');
        $routes->get('delete/(:num)', 'Monitoring::delete/$1');
    });

    // Admin-Only Routes (Protected by AdminFilter)
    $routes->group('', ['filter' => 'admin'], function(RouteCollection $routes) {
        
        // Categories CRUD
        $routes->group('categories', function(RouteCollection $routes) {
            $routes->get('/', 'Categories::index');
            $routes->post('store', 'Categories::store');
            $routes->post('update/(:num)', 'Categories::update/$1');
            $routes->get('delete/(:num)', 'Categories::delete/$1');
        });

        // Users CRUD
        $routes->group('users', function(RouteCollection $routes) {
            $routes->get('/', 'Users::index');
            $routes->post('store', 'Users::store');
            $routes->post('update/(:num)', 'Users::update/$1');
            $routes->get('delete/(:num)', 'Users::delete/$1');
        });
    });
});
