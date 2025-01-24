<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'ProductController::categories');
$routes->get('/categories', 'ProductController::categories');
$routes->get('/products/list/(:any)', 'ProductController::list/$1');
$routes->post('/products/compare', 'ProductController::compare');
