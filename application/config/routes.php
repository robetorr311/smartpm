<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'auth';
$route['404_override'] = '404';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'auth/login';
$route['auth']['post'] = 'auth/auth';
$route['signup'] = 'auth/signup';
$route['register']['post'] = 'auth/register';
$route['logout']['post'] = 'auth/logout';

$route['migrate/do_migration'] = 'migrate/do_migration';
$route['migrate/undo_migration'] = 'migrate/undo_migration';
$route['migrate/undo_migration/(:num)'] = 'migrate/undo_migration/$1';
$route['migrate/reset_migration'] = 'migrate/reset_migration';

$route['dashboard'] = 'dashboard/index';
$route['dashboard/(:num)/addphoto'] = 'dashboard/addphoto';
$route['dashboard/(:num)/alljobreport'] = 'dashboard/alljobreport';
$route['dashboard/(:num)/adddoc'] = 'dashboard/adddoc';

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
$route['cash_job/(:num)/addTeam'] = 'cash_jobs/addTeam';
$route['cash_job/(:num)/delete'] = 'cash_jobs/delete';

$route['insurance_jobs'] = 'insurance_jobs/index';
$route['insurance_job/(:num)'] = 'insurance_jobs/view';
$route['insurance_job/(:num)/addTeam'] = 'insurance_job/addTeam';
$route['insurance_job/(:num)/delete'] = 'insurance_job/delete';

$route['labor_jobs'] = 'labor_jobs/index';
$route['labor_job/(:num)'] = 'labor_jobs/view';
$route['labor_job/(:num)/addTeam'] = 'labor_jobs/addTeam';
$route['labor_job/(:num)/delete'] = 'labor_jobs/delete';


$route['productions'] = 'productions/index';
$route['production/(:num)'] = 'productions/view';
$route['production/(:num)/complete'] = 'productions/complete';

$route['work_complete'] = 'work_complete/index';
$route['work_complete/(:num)'] = 'work_complete/view';
$route['work_complete/(:num)/complete'] = 'work_complete/complete';

$route['closed'] = 'closed/index';

$route['teams'] = 'teams/index';
$route['teams/(:num)'] = 'teams/index/$1';
$route['team/create'] = 'teams/create';
$route['team/store']['post'] = 'teams/store';
$route['team/(:num)'] = 'teams/show/$1';
$route['team/(:num)/edit'] = 'teams/edit/$1';
$route['team/(:num)/update']['post'] = 'teams/update/$1';
$route['team/(:num)/delete']['post'] = 'teams/delete/$1';

$route['server/photo_upload'] = 'server/ajaxupload_jobphoto';
$route['server/photo_save'] = 'server/ajaxsave_jobphoto';
$route['server/photo_delete'] = 'server/deletephoto';
$route['server/photo_rotate'] = 'server/imagerotate';

$route['server/doc_upload'] = 'server/ajaxupload_jobdoc';
$route['server/doc_save'] = 'server/ajaxsave_jobdoc';
$route['server/doc_delete'] = 'server/deletedoc';
$route['server/doc_update'] = 'server/updatedocname';

$route['users'] = 'users/index';
$route['user/(:num)'] = 'users/view';
$route['user/(:num)/delete'] = 'users/delete';
$route['user/adduser'] = 'users/adduser';

$route['setting/status'] = 'setting/status_tag';
$route['setting/(:num)/delete'] = 'setting/deltag';


$route['(.+)'] = 'errors/page_missing';
