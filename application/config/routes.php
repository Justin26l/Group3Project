<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = 'Mod_ctrl/login';
$route['loginverify'] = "Mod_ctrl/loginverify";
$route['dashboard'] = "Mod_ctrl/dashboard";
$route['element'] = "Mod_ctrl/element";
$route['booking'] = "Mod_ctrl/booking";
$route['logout'] = "Mod_ctrl/logout";

$route['api/(:any)/(:any)'] = "Api_ctrl/api/$1/$2";

$route['test'] = 'Test_ctrl/test';