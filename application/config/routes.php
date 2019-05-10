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
$route['default_controller'] = 'account';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['tasks'] = 'tasks/index';
$route['tasks/(:num)'] = 'tasks/index/$1';
$route['task/create'] = 'tasks/create';
$route['task/store']['post'] = 'tasks/store';
$route['task/(:num)'] = 'tasks/show/$1';
$route['task/(:num)/complete']['post'] = 'tasks/complete/$1';
$route['task/(:num)/add-note']['post'] = 'tasks/addNote/$1';
$route['task/(:num)/note/(:num)/delete']['post'] = 'tasks/deleteNote/$1/$2';
$route['task/(:num)/edit'] = 'tasks/edit/$1';
$route['task/(:num)/update']['post'] = 'tasks/update/$1';
$route['task/(:num)/delete']['post'] = 'tasks/delete/$1';

$route['leads'] = 'leads/index';
$route['lead/(:num)'] = 'leads/view';
$route['lead/(:num)/edit'] = 'leads/edit';
$route['lead/(:num)/update'] = 'leads/update';
$route['lead/new'] = 'leads/new';
$route['lead/store'] = 'leads/store';
$route['lead/updatestatus'] = 'leads/updatestatus';

$route['party/(:num)/add'] = 'party/index';
$route['party/(:num)/update'] = 'party/update';

$route['cash_jobs'] = 'cash_jobs/index';
$route['cash_job/(:num)'] = 'cash_jobs/view';

$route['insurance_jobs'] = 'insurance_jobs/index';
$route['insurance_job/(:num)'] = 'insurance_jobs/view';

$route['teams'] = 'teams/index';
$route['team/(:num)'] = 'teams/view';
$route['team/(:num)/edit'] = 'teams/edit';
$route['team/(:num)/update'] = 'teams/update';
$route['team/(:num)/delete'] = 'teams/delete';
$route['team/new'] = 'teams/new';
$route['team/store'] = 'teams/store';


