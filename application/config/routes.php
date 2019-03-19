<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

|	http://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There area two reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router what URI segments to use if those provided

| in the URL cannot be matched to a valid route.

|

*/

$route['default_controller'] = "home";
$route['page/(:any)'] = 'page/page/index/$1';
$route['login'] = 'users/login';
$route['contact-us'] = 'home/contact';
$route['register'] = 'users/register';
$route['join'] = 'users/register/join_referral';
$route['event/index'] = 'event';
$route['event/(:num)'] = 'event/view/$1';
$route['reff/(:any)'] = 'affiliate/reff_url/$1';
$route['e/(:any)'] = 'affiliate/reff_event_url/$1';
$route['404_override'] = 'error/page/e404';
$route['sitemap\.xml'] = "page/sitemap";
$route['sitemap\.xml'] = $route['sitemap\.xml'];
$route['rss_action'] = "page/rss_action";
$route['rss_country/(:any)'] = 'page/rss_country/$1';
//added by ajay
$route[ADMIN_LOGIN_PATH] = 'login/admin';
$route[ADMIN_DASHBOARD_PATH] = 'dashboard/admin';
$route[ADMIN_DASHBOARD_PATH.'/logout'] = 'login/admin/logout';
$route[ADMIN_DASHBOARD_PATH.'/([a-zA-Z_-]+)/(:any)'] = '$1/admin/$2';



/* End of file routes.php */
/* Location: ./application/config/routes.php */