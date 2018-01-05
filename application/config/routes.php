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
$route['default_controller'] = 'home';

/** Administrator Routes * */
$route['admin'] = 'admin/login';
$route['admin/logout'] = 'admin/login/logout';
$route['admin/forgot_password'] = 'admin/login/forgot_password';
$route['admin/reset_password'] = 'admin/login/reset_password';
$route['admin/profile'] = 'admin/dashboard/profile';
$route['admin/users/posts/view/(:any)/(:any)'] = 'admin/posts/view/$1/$2';
$route['admin/users/posts/(:any)'] = 'admin/posts/index/$1';

/** User Routes * */
$route['forgot_password'] = 'login/forgot_password';
$route['reset_password'] = 'login/reset_password';
$route['verify'] = 'signup/verify';

/* Profile Routes */

$route['profile/load_posts/(:any)/(:any)/(:any)'] = 'profile/load_posts/$1/$2/$3';
$route['profile/load_timeline/(:any)/(:any)'] = 'profile/load_timeline/$1/$2';
$route['profile/view_timeline/(:any)'] = 'profile/view_timeline/$1';
$route['profile/upload_cover_image'] = 'profile/upload_cover_image';

$route['profile/create'] = 'profile/create';
$route['profile/edit/(:any)'] = 'profile/edit/$1';

$route['profile/upload_gallery'] = 'profile/upload_gallery';
$route['profile/delete_gallery'] = 'profile/delete_gallery';
$route['profile/proceed_steps'] = 'profile/proceed_steps';
$route['profile/add_facts'] = 'profile/add_facts';
$route['profile/check_facts/(:any)'] = 'profile/check_facts/$1';
$route['profile/delete_facts'] = 'profile/delete_facts';
$route['profile/add_affiliation'] = 'profile/add_affiliation';
$route['profile/check_affiliation/(:any)'] = 'profile/check_affiliation/$1';
$route['profile/delete_affiliation'] = 'profile/delete_affiliation';
$route['profile/add_timeline'] = 'profile/add_timeline';
$route['profile/delete_timeline'] = 'profile/delete_timeline';
$route['profile/lifetimeline'] = 'profile/lifetimeline';
$route['profile/get_states'] = 'profile/get_states';
$route['profile/get_cities'] = 'profile/get_cities';
$route['profile/add_services'] = 'profile/add_services';
$route['profile/add_fundraiser'] = 'profile/add_fundraiser';
$route['profile/delete_fundmedia'] = 'profile/delete_fundmedia';
$route['profile/upload_post'] = 'profile/upload_post';
$route['profile/delete_post'] = 'profile/delete_post';
$route['profile/(:any)'] = 'profile/index/$1';

$route['flowers/view'] = 'flowers/view';
$route['flowers/cart'] = 'flowers/cart';
$route['flowers/get_data'] = 'flowers/get_data';
$route['flowers/place_order'] = 'flowers/place_order';
$route['flowers/get_order_total'] = 'flowers/get_order_total';
$route['flowers/get_order_details'] = 'flowers/get_order_details';
$route['flowers/(:any)'] = 'flowers/index/$1';
$route['blog/(:any)'] = 'blog/index/$1';
$route['logout'] = 'login/logout';
$route['editprofile'] = 'users/edit_profile';
$route['changepassword'] = 'users/update_password';
$route['dashboard/(:any)'] = 'dashboard/index/$1';
//-- Search autocomplete routes
$route['search/autocomplete'] = 'search/autocomplete';
$route['search/get_result'] = 'search/get_result';
$route['search/(:any)'] = 'search/index/$1';
//$route['dashboard/(:any)/profile_publish/(:any)'] = 'dashboard/profile_publish/$2';

$route['pages/(:any)'] = 'cms/index/$1';

$route['404_override'] = 'pagenotfound';
$route['translate_uri_dashes'] = FALSE;
