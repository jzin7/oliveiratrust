<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('cliente');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Cliente::index');
$routes->add('cliente/(:num)', 'Cliente::index/$1');

//$routes->add('recuperarSenha', 'Login::recuperarSenha');
//$routes->add('cadastro', 'Login::loginCadastro');
//$routes->add('loginLista', 'Login::loginLista');
//$routes->add('/(:num)', 'Login::index/$1');

//$routes->add('login/lista/(:any)', 'Login::lista/$1');
//$routes->add('loginsForm/(:num)', 'Login::loginsForm/$1');
//dinamico. Se aceitar só numero é só por 'num' ao inves de any
//$routes->add('recuperarSenha/(:any)/(:any)', 'Login::recuperarSenha/$1/$2');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
