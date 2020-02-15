<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['match']['get'] = "matching/match";
$route['populate']['get'] = "matching/populate";
$route['status/(:num)/(:num)']['get'] = "matching/status/$1/$2";
$route['status/flush']['get'] = "matching/status_flush";
//update $1 - messanger id, $2 - what to update, $3 - variable
$route['update/(:any)/(:any)']['get'] = "matching/update/$1/$2";