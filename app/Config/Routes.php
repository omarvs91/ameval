<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('clientes', 'Home::clientes');
$routes->get('clientes/(:any)', 'Home::clientes/$1');
$routes->post('clientes', 'Home::clientes');
$routes->post('clientes/(:any)', 'Home::clientes');
$routes->get('estado_comprobantes','Home::estado_comprobantes');
$routes->get('estado_comprobantes/(:any)','Home::estado_comprobantes/$1');
$routes->post('estado_comprobantes','Home::estado_comprobantes');
$routes->post('estado_comprobantes/(:any)','Home::estado_comprobantes');
$routes->get('estado_ropa','Home::estado_ropa');
$routes->get('estado_ropa/(:any)','Home::estado_ropa/$1');
$routes->post('estado_ropa','Home::estado_ropa');
$routes->post('estado_ropa/(:any)','Home::estado_ropa');
$routes->get('metodo_pago','Home::metodo_pago');
$routes->get('metodo_pago/(:any)','Home::metodo_pago/$1');
$routes->post('metodo_pago','Home::metodo_pago');
$routes->post('metodo_pago/(:any)','Home::metodo_pago');
$routes->get('roles','Home::roles');
$routes->get('roles/(:any)','Home::roles/$1');
$routes->post('roles','Home::roles');
$routes->post('roles/(:any)','Home::roles');
$routes->get('servicios','Home::servicios');
$routes->get('servicios/(:any)','Home::servicios/$1');
$routes->post('servicios','Home::servicios');
$routes->post('servicios/(:any)','Home::servicios');

$routes->get('users','Home::users');
$routes->get('users/(:any)','Home::users/$1');
$routes->post('users','Home::users');
$routes->post('users/(:any)','Home::users');

$routes->get('change_password/(:any)','Home::change_password/$1');
$routes->post('change_password/(:any)','Home::change_password');

$routes->get('locales','Home::locales');
$routes->get('locales/(:any)','Home::locales/$1');
$routes->post('locales','Home::locales');
$routes->post('locales/(:any)','Home::locales');

$routes->get('comprobantes','Home::comprobantes');
$routes->get('comprobantes/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes','Home::comprobantes');
$routes->post('comprobantes/(:any)','Home::comprobantes');

$routes->get('comprobantes_en_curso','Home::comprobantes');
$routes->get('comprobantes_en_curso/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_en_curso','Home::comprobantes');
$routes->post('comprobantes_en_curso/(:any)','Home::comprobantes');

$routes->get('comprobantes_pagados','Home::comprobantes');
$routes->get('comprobantes_pagados/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_pagados','Home::comprobantes');
$routes->post('comprobantes_pagados/(:any)','Home::comprobantes');

$routes->get('comprobantes_pendiente_pago','Home::comprobantes');
$routes->get('comprobantes_pendiente_pago/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_pendiente_pago','Home::comprobantes');
$routes->post('comprobantes_pendiente_pago/(:any)','Home::comprobantes');

$routes->get('comprobantes_recojo','Home::comprobantes');
$routes->get('comprobantes_recojo/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_recojo','Home::comprobantes');
$routes->post('comprobantes_recojo/(:any)','Home::comprobantes');

$routes->get('registrar_comprobante','Home::registrar_comprobante');
$routes->get('fetchServicios','Home::fetchServicios');
$routes->get('fetchServicioDetails','Home::fetchServicioDetails');
$routes->get('fetchServicioDetails/(:any)','Home::fetchServicioDetails/$1');
$routes->post('fetchServicioDetails','Home::fetchServicioDetails');
$routes->post('fetchServicioDetails/(:any)','Home::fetchServicioDetails');
$routes->get('fetchMetodoPago','Home::fetchMetodoPago');
$routes->get('fetchClientes','Home::fetchClientes');
$routes->get('fetchEstadocomprobantes','Home::fetchEstadocomprobantes');
$routes->post('submit_comprobante','Home::submit_comprobantes_form');

$routes->get('ver_detalles/(:any)','Home::view_details/$1');

$routes->get('logout','Auth::logout');
$routes->get('login', 'Auth::login');
$routes->post('authenticate', 'Auth::authenticate');

$routes->get('comprobante/(:num)/a4', 'Home::generatePdfA4/$1');
$routes->get('comprobante/(:num)/a4/(:any)', 'Home::generatePdfA4/$1');
$routes->get('comprobante/(:num)/58mm', 'Home::generatePdf58mm/$1');
$routes->get('comprobante/(:num)/58mm/(:any)', 'Home::generatePdf58mm/$1');

$routes->get('whatsapp','Home::whatsapp');

$routes->post('exportcsv','Home::exportCSV');

$routes->get('op_materiales', 'Home::materiales');
$routes->get('op_materiales/(:any)', 'Home::materiales/$1');
$routes->post('op_materiales', 'Home::materiales');
$routes->post('op_materiales/(:any)', 'Home::materiales');

$routes->get('empleados', 'Home::empleados');
$routes->get('empleados/(:any)', 'Home::empleados/$1');
$routes->post('empleados', 'Home::empleados');
$routes->post('empleados/(:any)', 'Home::empleados');

$routes->get('op_gastos_indirectos', 'Home::gastos_indirectos');
$routes->get('op_gastos_indirectos/(:any)', 'Home::gastos_indirectos/$1');
$routes->post('op_gastos_indirectos', 'Home::gastos_indirectos');
$routes->post('op_gastos_indirectos/(:any)', 'Home::gastos_indirectos');

$routes->get('op', 'Home::op');
$routes->get('op/(:any)', 'Home::op/$1');
$routes->post('op', 'Home::op');
$routes->post('op/(:any)', 'Home::op');

$routes->get('op_culminadas', 'Home::op');
$routes->get('op_culminadas/(:any)', 'Home::op/$1');
$routes->post('op_culminadas', 'Home::op');
$routes->post('op_culminadas/(:any)', 'Home::op');

$routes->get('estados', 'Home::estados');
$routes->get('estados/(:any)', 'Home::estados/$1');
$routes->post('estados', 'Home::estados');
$routes->post('estados/(:any)', 'Home::estados');

$routes->get('op_mano_obra/(:num)', 'Home::op_mano_obra');
$routes->get('op_mano_obra/(:num)/(:any)', 'Home::op_mano_obra/$1');
$routes->post('op_mano_obra/(:num)', 'Home::op_mano_obra');
$routes->post('op_mano_obra/(:num)/(:any)', 'Home::op_mano_obra');