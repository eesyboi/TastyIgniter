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
$route['default_controller'] = 'home/view';
$route['(:any)'] = 'pages/view/$1';*/
//$route['(:any)'] = '404_override';

$route['default_controller'] 		= 'main/home';
$route['home'] 						= 'main/home';
$route['aboutus'] 					= 'main/home/aboutus';
$route['contact'] 					= 'main/contact';
$route['distance'] 					= 'main/home/distance';
$route['home/autocomplete'] 		= 'main/home/autocomplete';
$route['menus'] 					= 'main/menus';
$route['menus/category/:num'] 		= 'main/menus';
$route['menus/review'] 				= 'main/menus/review';
$route['menus/write_review'] 		= 'main/menus/write_review';
$route['specials'] 					= 'main/specials';
//$route['cart'] 						= 'main/cart';
//$route['modules/cart'] 				= "modules/cart/welcome";

//$route['cart/add'] 					= 'main/cart/add';
$route['cart/update'] 				= 'main/cart/update';
$route['cart/coupon'] 				= 'main/cart/coupon';
$route['checkout'] 					= 'main/checkout';
$route['payments'] 					= 'main/payments';
$route['payments/paypal'] 			= 'main/payments/paypal';
$route['checkout/success'] 			= 'main/checkout/success';
$route['find/table'] 				= 'main/find_table';
$route['reserve/table'] 			= 'main/reserve_table';
$route['account/login'] 			= 'main/login';
$route['account/logout'] 			= 'main/logout';
$route['account/register'] 			= 'main/register';
$route['account/password/reset'] 	= 'main/password_reset';
$route['account'] 					= 'main/account';
$route['account/details'] 			= 'main/details';
$route['account/address'] 			= 'main/address';
$route['account/address/edit'] 		= 'main/address/edit';
$route['account/address/edit/:any'] = 'main/address/edit';
$route['account/orders'] 			= 'main/orders';
$route['account/orders/:num'] 		= 'main/orders/view';
$route['account/inbox'] 			= 'main/inbox';
$route['account/inbox/view/:num'] 	= 'main/inbox/view';


$route['admin'] 					= 'admin/dashboard';

$route['admin/login'] 				= 'admin/login';

$route['admin/permission'] 			= 'admin/permission';

$route['admin/logout'] 				= 'admin/logout';

$route['admin/dashboard'] 			= 'admin/dashboard';

$route['admin/menus'] 				= 'admin/menus';
//$route['admin/menus&page=:num'] 	= 'admin/menus';
$route['admin/menus/edit/:num'] 	= 'admin/menus/edit';

$route['admin/menus/options'] 		= 'admin/menu_options';
$route['admin/menus/options/edit/:num'] = 'admin/menu_options/edit';

$route['admin/categories'] 			= 'admin/categories';
$route['admin/categories/edit/:num'] 	= 'admin/categories/edit';

$route['admin/specials'] 			= 'admin/specials';
$route['admin/specials/edit/:num'] 	= 'admin/specials/edit';

$route['admin/reviews'] 			= 'admin/reviews';
$route['admin/reviews/edit/:num'] 	= 'admin/reviews/edit';

$route['admin/customers'] 			= 'admin/customers';
$route['admin/customers/:num'] 		= 'admin/customers';
$route['admin/customers/edit/:num'] = 'admin/customers/edit';

$route['admin/orders'] 				= 'admin/orders';
$route['admin/orders/:num'] 		= 'admin/orders';
$route['admin/orders/assigned'] 	= 'admin/orders/assigned';
$route['admin/orders/edit/:num'] 	= 'admin/orders/edit';

$route['admin/reservations'] 		= 'admin/reservations';
$route['admin/reservations/edit/:num'] 		= 'admin/reservations/edit';

$route['admin/staffs'] 				= 'admin/staffs';

$route['admin/departments'] 		= 'admin/departments';
$route['admin/departments/edit/:num'] 	= 'admin/departments/edit';

$route['admin/messages'] 			= 'admin/messages';
$route['admin/messages/view/:num'] 	= 'admin/messages/view';

$route['admin/alerts'] 				= 'admin/alerts';
$route['admin/alerts/view/:num'] 	= 'admin/alerts/view';

$route['admin/settings'] 			= 'admin/settings';

$route['admin/tables'] 				= 'admin/tables';
$route['admin/tables/edit/'] 		= 'admin/tables/edit';

$route['admin/locations'] 			= 'admin/locations';
$route['admin/locations/:num'] 		= 'admin/locations';
$route['admin/locations/edit/'] 	= 'admin/locations/edit';

$route['admin/security_questions'] 	= 'admin/security_questions';
$route['admin/security_questions/edit/:num'] = 'admin/security_questions/edit';

$route['admin/statuses'] 			= 'admin/statuses';
$route['admin/statuses/edit/:num'] = 'admin/statuses/edit';

$route['admin/currencies'] 			= 'admin/currencies';
$route['admin/currencies/edit/:num'] 	= 'admin/currencies/edit';

$route['admin/countries'] 			= 'admin/countries';
$route['admin/countries/edit/:num'] = 'admin/countries/edit';

$route['admin/payments'] 			= 'admin/payments';
$route['admin/paypal_express'] 		= 'admin/paypal_express';

$route['admin/error_logs'] 			= 'admin/error_logs';

$route['admin/backup'] 				= 'admin/backup';

$route['admin/coupons'] 			= 'admin/coupons';
$route['admin/coupons/edit/:num'] 	= 'admin/coupons/edit';

$route['admin/extensions'] 			= 'admin/extensions';

$route['admin/extensions/cart'] 	= 'admin/cart_module';


/* End of file routes.php */
/* Location: ./application/config/routes.php */