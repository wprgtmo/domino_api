<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes){

	// Eventos CRUD
	$routes->get('eventos', 'Eventos::index');
	$routes->post('eventos/create', 'Eventos::crear');
	$routes->get('eventos/edit/(:num)', 'Eventos::editar/$1');
	$routes->put('eventos/update/(:num)', 'Eventos::actualizar/$1');
	$routes->delete('eventos/delete/(:num)', 'Eventos::eliminar/$1');

	// Eventos Reglas de negocio

	// Eventos según el estado	
	$routes->get('eventos/creados', 'Eventos::index/C');
	$routes->get('eventos/iniciados', 'Eventos::index/I');
	$routes->get('eventos/finalizados', 'Eventos::index/F');

	// Acciones solicitadas al evento	
	$routes->post('evento/iniciar', 'Eventos::iniciar');
	$routes->post('evento/finalizar', 'Eventos::finalizar');
	$routes->post('evento/ronda/nueva', 'Eventos::rondaNueva');
	$routes->post('evento/rondas', 'Eventos::rondas');
	$routes->post('evento/mesas', 'Eventos::mesas');
	$routes->post('evento/boletas', 'Eventos::boletas');
	$routes->post('evento/boletas/completa', 'Eventos::boletasCompleta');
	$routes->post('evento/parejas', 'Eventos::parejas');
	
	// Datos especificos del evento	
	// $routes->get('evento/(:num)/rondas', 'Eventos::rondas/$1');
	// $routes->get('evento/(:num)/mesas', 'Eventos::mesas/$1');

	$routes->get('evento/(:num)/ronda/activa', 'Eventos::rondaActiva/$1');
	$routes->get('evento/(:num)/ronda/proxima', 'Eventos::proximaRonda/$1');
	$routes->get('evento/(:num)/parejas', 'Eventos::parejas/$1');
	$routes->get('evento/(:num)/mesa/(:num)/parejas', 'Eventos::parejasMesa/$1/$2');
	
	$routes->get('evento/(:num)/mesa/(:num)/boleta/ronda/activa', 'Eventos::boleta/$1/$2');
	$routes->get('evento/(:num)/mesa/(:num)/boleta/ronda/(:num)', 'Eventos::boleta/$1/$2/$3');

	$routes->get('evento/(:num)/mesa/(:num)/boletas', 'Eventos::boletasMesa/$1/$2');

	
	$routes->get('evento/(:num)/cant_rondas', 'Eventos::cantRondas/$1');
	
	// Jugadores CRUD		
	$routes->get('jugadores', 'Jugadores::index');
	$routes->post('jugadores/crear', 'Jugadores::create');
	$routes->get('jugadores/edit/(:num)', 'Jugadores::edit/$1');
	$routes->put('jugadores/update/(:num)', 'Jugadores::update/$1');
	$routes->delete('jugadores/eliminar/(:num)', 'Jugadores::delete/$1');

	// Jugadores Reglas de negocio
	$routes->get('jugador/(:num)', 'Jugadores::Jugador/$1');

	$routes->get('parejas', 'Parejas::index');
	$routes->post('parejas/create', 'Parejas::create');
	$routes->get('parejas/edit/(:num)', 'Parejas::edit/$1');
	$routes->put('parejas/update/(:num)', 'Parejas::update/$1');
	$routes->delete('parejas/delete/(:num)', 'Parejas::delete/$1');
	
	$routes->get('pareja/(:num)', 'Parejas::getPareja/$1');

	$routes->get('boletas', 'Boletas::index');
	$routes->post('boletas/create', 'Boletas::create');
	$routes->get('boletas/edit/(:num)', 'Boletas::edit/$1');
	$routes->put('boletas/update/(:num)', 'Boletas::update/$1');
	$routes->delete('boletas/delete/(:num)', 'Boletas::delete/$1');

	$routes->get('boletaparejas', 'BoletaParejas::index');
	$routes->post('boletaparejas/create', 'BoletaParejas::create');
	$routes->get('boletaparejas/edit/(:num)', 'BoletaParejas::edit/$1');
	$routes->put('boletaparejas/update/(:num)', 'BoletaParejas::update/$1');
	$routes->delete('boletaparejas/delete/(:num)', 'BoletaParejas::delete/$1');
	
	$routes->get('boletaparejas/salidor/(:num)', 'BoletaParejas::salidor/$1');



	$routes->get('datas', 'Datas::index');
	$routes->post('datas/create', 'Datas::create');
	$routes->get('datas/edit/(:num)', 'Datas::edit/$1');
	$routes->put('datas/update/(:num)', 'Datas::update/$1');
	$routes->delete('datas/delete/(:num)', 'Datas::delete/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
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
