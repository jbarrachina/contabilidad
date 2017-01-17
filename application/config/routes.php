<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] =  'Apuntes_controller'; //'welcome';

$route['apuntes/pagina/(:num)'] = 'Apuntes_controller';//cuando no sea la primera página
$route['apuntes/pagina'] = 'Apuntes_controller';//cuando sea la primera página

$route['apuntes/accion'] = 'Apuntes_controller/accion';
$route['apuntes/observaciones/(:num)'] = 'Apuntes_controller/actualizaObservaciones';
$route['apuntes/search'] = 'Apuntes_controller/search';
$route['apuntes/search/(:any)/(:num)'] = 'Apuntes_controller/search';
$route['apuntes/search/(:any)'] = 'Apuntes_controller/search';
$route['apuntes/importar'] = 'Apuntes_controller/importar';
$route['apuntes/listado'] = 'Apuntes_controller/listado';
$route['apuntes/change_year/(:num)'] = 'Apuntes_controller/change_year';
$route['apuntes/republic'] = 'Apuntes_controller/republic';

$route['desglose/(:num)'] = 'Desglose_controller';
$route['desglose/addDesglose'] = 'Desglose_controller/addDesglose';

$route['desglose/(:num)/(:num)'] = 'Desglose_controller/deleteDesglose';

$route['pendientes'] = 'Pendientes_controller';
$route['pendientes/add_pendiente'] = 'Pendientes_controller/add_pendiente';
$route['pendientes/autoriza/(:num)'] = 'Pendientes_controller/autoriza';
$route['pendientes/copia/(:any)'] = 'Pendientes_controller/autoriza';

$route['fotocopias/familias/(:num)/(:num)'] = 'Fotocopias_controller/porFamilias';
$route['fotocopias/profesores/(:num)/(:num)/(:any)'] = 'Fotocopias_controller/porProfesores';


$route['404_override'] = '';

$route['translate_uri_dashes'] = FALSE;

$route['apuntes'] = "Apuntes_controller";
