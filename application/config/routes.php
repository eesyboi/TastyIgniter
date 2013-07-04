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

/*$route['default_controller'] = "welcome";
$route['404_override'] = '';
$route['default_controller'] = 'pages/view';
$route['(:any)'] = 'pages/view/$1';*/


$route['account'] = 'account';
$route['checkout/register'] = 'checkout/register';
$route['checkout/logout'] = 'checkout/logout';
$route['checkout/login'] = 'checkout/login';
$route['checkout'] = 'checkout';
$route['cart/add'] = 'cart/add';
$route['cart'] = 'cart';
$route['foods'] = 'foods';
$route['foods/(:any)'] = 'foods';
$route['aboutus'] = 'pages/aboutus';
$route['(:any)'] = 'pages/home';
$route['default_controller'] = 'pages/home';


$route['admin/foods/remove'] = 'admin/foods/remove';
$route['admin/foods/add'] = 'admin/foods/add';
$route['admin/foods'] = 'admin/foods';
$route['admin/categories/remove'] = 'admin/categories/remove';
$route['admin/categories/add'] = 'admin/categories/add';
$route['admin/categories'] = 'admin/categories';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/login'] = 'admin/login';
$route['admin/logout'] = 'admin/logout';
$route['admin/(:any)'] = 'admin/dashboard';


/* End of file routes.php */
/* Location: ./application/config/routes.php */