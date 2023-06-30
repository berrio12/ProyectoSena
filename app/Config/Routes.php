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
$routes->post('usuarios/validar', 'Usuarios::verificar');
$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
	$routes->get('usuarios', 'Usuarios::index');
	$routes->get('usuarios/nuevo', 'Usuarios::nuevo');
	$routes->post('usuarios/registrar', 'Usuarios::registrar');
	$routes->put('usuarios/actualizar', 'Usuarios::actualizar');
	$routes->get('usuarios/editar/(:num)', 'Usuarios::editar/$1');
	$routes->delete('usuarios/eliminar/(:num)', 'Usuarios::eliminar/$1');
	$routes->get('usuarios/vaciar', 'Usuarios::vaciar');
	$routes->get('usuarios/reciclaje', 'Usuarios::reciclaje');
	$routes->get('usuarios/perfil', 'Usuarios::perfil');
	$routes->delete('usuarios/delete/(:num)', 'Usuarios::delete/$1');
	$routes->get('usuarios/rol/(:num)', 'Usuarios::rol/$1');

	$routes->get('cajas', 'Cajas::index');
	$routes->get('cajas/nuevo', 'Cajas::nuevo');
	$routes->get('cajas/cerrar', 'Cajas::cerrar');
	$routes->post('cajas/registrar', 'Cajas::registrar');
	$routes->put('cajas/actualizar', 'Cajas::actualizar');
	$routes->get('cajas/editar/(:num)', 'Cajas::editar/$1');
	$routes->delete('cajas/eliminar/(:num)', 'Cajas::eliminar/$1');
	$routes->get('cajas/vaciar', 'Cajas::vaciar');
	$routes->get('cajas/reciclaje', 'Cajas::reciclaje');
	$routes->delete('cajas/delete/(:num)', 'Cajas::delete/$1');

	$routes->post('compras/ingresar', 'Compras::ingresar');

	$routes->get('clientes', 'Clientes::index');
	$routes->get('clientes/nuevo', 'Clientes::nuevo');
	$routes->post('clientes/registrar', 'Clientes::registrar');
	$routes->put('clientes/actualizar', 'Clientes::actualizar');
	$routes->get('clientes/editar/(:num)', 'Clientes::editar/$1');
	$routes->delete('clientes/eliminar/(:num)', 'Clientes::eliminar/$1');
	$routes->get('clientes/vaciar', 'Clientes::vaciar');
	$routes->get('clientes/reciclaje', 'Clientes::reciclaje');
	$routes->delete('clientes/delete/(:num)', 'Clientes::delete/$1');

	$routes->get('categorias', 'Categorias::index');
	$routes->get('categorias/nuevo', 'Categorias::nuevo');
	$routes->post('categorias/registrar', 'Categorias::registrar');
	$routes->put('categorias/actualizar', 'Categorias::actualizar');
	$routes->get('categorias/editar/(:num)', 'Categorias::editar/$1');
	$routes->delete('categorias/eliminar/(:num)', 'Categorias::eliminar/$1');
	$routes->get('categorias/vaciar', 'Categorias::vaciar');
	$routes->get('categorias/reciclaje', 'Categorias::reciclaje');
	$routes->delete('categorias/delete/(:num)', 'Categorias::delete/$1');

	$routes->get('medidas', 'Medidas::index');
	$routes->get('medidas/nuevo', 'Medidas::nuevo');
	$routes->post('medidas/registrar', 'Medidas::registrar');
	$routes->put('medidas/actualizar', 'Medidas::actualizar');
	$routes->get('medidas/editar/(:num)', 'Medidas::editar/$1');
	$routes->delete('medidas/eliminar/(:num)', 'Medidas::eliminar/$1');
	$routes->get('medidas/vaciar', 'Medidas::vaciar');
	$routes->get('medidas/reciclaje', 'Medidas::reciclaje');
	$routes->delete('medidas/delete/(:num)', 'Medidas::delete/$1');

	$routes->get('marcas', 'Marcas::index');
	$routes->get('marcas/nuevo', 'Marcas::nuevo');
	$routes->post('marcas/registrar', 'Marcas::registrar');
	$routes->put('marcas/actualizar', 'Marcas::actualizar');
	$routes->get('marcas/editar/(:num)', 'Marcas::editar/$1');
	$routes->delete('marcas/eliminar/(:num)', 'Marcas::eliminar/$1');
	$routes->get('marcas/vaciar', 'Marcas::vaciar');
	$routes->get('marcas/reciclaje', 'Marcas::reciclaje');
	$routes->delete('marcas/delete/(:num)', 'Marcas::delete/$1');

	$routes->get('productos', 'Productos::index');
	$routes->get('productos/nuevo', 'Productos::nuevo');
	$routes->post('productos/registrar', 'Productos::registrar');
	$routes->put('productos/actualizar', 'Productos::actualizar');
	$routes->get('productos/editar/(:num)', 'Productos::editar/$1');
	$routes->delete('productos/eliminar/(:num)', 'Productos::eliminar/$1');
	$routes->get('productos/vaciar', 'Productos::vaciar');
	$routes->get('productos/reciclaje', 'Productos::reciclaje');
	$routes->delete('productos/delete/(:num)', 'Productos::delete/$1');

	$routes->get('compras', 'Compras::index');
	$routes->get('compras/historial', 'Compras::historial');
	$routes->get('compras/eliminar/(:num)', 'Compras::eliminar/$1');
	$routes->get('compras/generar', 'Compras::generar');

	$routes->get('ventas', 'Ventas::index');
	$routes->get('ventas/historial', 'Ventas::historial');
	$routes->get('compras/generarPdf/(:num)', 'Compras::generarPdf/$1');
	$routes->get('ventas/generarPdf/(:num)', 'Ventas::generarPdf/$1');
	$routes->get('ventas/eliminar/(:num)', 'Ventas::eliminar/$1');
	$routes->get('ventas/generar/(:num)', 'Ventas::generar/$1');
	$routes->get('ventas/anular/(:num)', 'Ventas::anular/$1');
	$routes->get('compras/anular/(:num)', 'Compras::anular/$1');

	$routes->get('admin/dashboard', 'Admin::dashboard');
	$routes->get('admin/grafico', 'Admin::grafico');
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
