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
$route['forgot-password'] = 'auth/forgotPassword';
$route['send-password-token']['post'] = 'auth/sendPasswordToken';
$route['reset-password/(:any)'] = 'auth/resetPassword/$1';
$route['set-token-verified-password/(:any)']['post'] = 'auth/setTokenVerifiedPassword/$1';
$route['signup'] = 'auth/signup';
$route['register']['post'] = 'auth/register';
$route['verification/(:any)'] = 'auth/verification/$1';
$route['logout']['post'] = 'auth/logout';

$route['migrate/do_migration'] = 'migrate/do_migration';
$route['migrate/undo_migration'] = 'migrate/undo_migration';
$route['migrate/undo_migration/(:num)'] = 'migrate/undo_migration/$1';
$route['migrate/reset_migration'] = 'migrate/reset_migration';

$route['dashboard'] = 'dashboard/index';

$route['photos/(:num)'] = 'photos/index/$1';
$route['photo/upload'] = 'photos/ajaxupload_jobphoto';
$route['photo/save'] = 'photos/ajaxsave_jobphoto';
$route['photo/delete'] = 'photos/deletephoto';
$route['photo/rotate'] = 'photos/imagerotate';

$route['docs/(:num)'] = 'docs/index/$1';
$route['doc/upload'] = 'docs/ajaxupload_jobdoc';
$route['doc/save'] = 'docs/ajaxsave_jobdoc';
$route['doc/delete'] = 'docs/deletedoc';
$route['doc/update'] = 'docs/updatedocname';

$route['users'] = 'users/index';
$route['users/(:num)'] = 'users/index/$1';
$route['user/create'] = 'users/create';
$route['user/store']['post'] = 'users/store';
$route['user/(:num)'] = 'users/show/$1';
$route['user/(:num)/edit'] = 'users/edit/$1';
$route['user/(:num)/update']['post'] = 'users/update/$1';
$route['user/(:num)/delete']['post'] = 'users/delete/$1';

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
$route['leads/(:num)'] = 'leads/index/$1';
$route['lead/(:num)'] = 'leads/view/$1';
$route['lead/(:num)/edit'] = 'leads/edit/$1';
$route['lead/(:num)/update'] = 'leads/update/$1';
$route['lead/new'] = 'leads/new';
$route['lead/store'] = 'leads/store';
$route['lead/updatestatus'] = 'leads/updatestatus';
$route['lead/(:num)/reports'] = 'leads/alljobreport/$1';
$route['lead/(:num)/delete-report'] = 'leads/deletejobreport/$1';

$route['party/(:num)/add'] = 'party/index/$1';
$route['party/(:num)/update'] = 'party/update/$1';

$route['cash-jobs'] = 'cash_jobs/index';
$route['cash-jobs/(:num)'] = 'cash_jobs/index/$1';
$route['cash-job/(:num)'] = 'cash_jobs/view/$1';
$route['cash-job/(:num)/addTeam'] = 'cash_jobs/addTeam/$1';
$route['cash-job/(:num)/delete'] = 'cash_jobs/delete/$1';

$route['insurance-jobs'] = 'insurance_jobs/index';
$route['insurance-jobs/(:num)'] = 'insurance_jobs/index/$1';
$route['insurance-job/(:num)'] = 'insurance_jobs/view/$1';
$route['insurance-job/(:num)/addTeam'] = 'insurance_jobs/addTeam/$1';
$route['insurance-job/(:num)/delete'] = 'insurance_jobs/delete/$1';

$route['labor-jobs'] = 'labor_jobs/index';
$route['labor-jobs/(:num)'] = 'labor_jobs/index/$1';
$route['labor-job/(:num)'] = 'labor_jobs/view/$1';
$route['labor-job/(:num)/addTeam'] = 'labor_jobs/addTeam/$1';
$route['labor-job/(:num)/delete'] = 'labor_jobs/delete/$1';


$route['productions'] = 'productions/index';
$route['productions/(:num)'] = 'productions/index/$1';
$route['production/(:num)'] = 'productions/view/$1';
$route['production/(:num)/mark-complete'] = 'productions/complete/$1';
$route['production/(:num)/mark-incomplete'] = 'productions/incomplete/$1';

$route['work-completed'] = 'work_complete/index';
$route['work-completed/(:num)'] = 'work_complete/index/$1';
$route['work-complete/(:num)'] = 'work_complete/view/$1';
$route['work-complete/(:num)/mark-complete'] = 'work_complete/complete/$1';
$route['work-complete/(:num)/mark-incomplete'] = 'work_complete/incomplete/$1';

$route['closed'] = 'closed/index/';
$route['closed/(:num)'] = 'closed/index/$1';
$route['close/(:num)'] = 'closed/view/$1';

$route['teams'] = 'teams/index';
$route['teams/(:num)'] = 'teams/index/$1';
$route['team/create'] = 'teams/create';
$route['team/store']['post'] = 'teams/store';
$route['team/(:num)'] = 'teams/show/$1';
$route['team/(:num)/edit'] = 'teams/edit/$1';
$route['team/(:num)/update']['post'] = 'teams/update/$1';
$route['team/(:num)/delete']['post'] = 'teams/delete/$1';

$route['setting'] = 'setting/index';
$route['setting/status'] = 'setting/status_tag';
$route['setting/newtag'] = 'setting/newtag';
$route['setting/(:num)/delete'] = 'setting/deltag';
$route['setting/ajaxupload'] = 'setting/ajaxupload';
$route['setting/ajaxsave'] = 'setting/ajaxsave';
$route['setting/ajaxcolor'] = 'setting/ajaxcolor';


$route['(.+)'] = 'errors/page_missing';
