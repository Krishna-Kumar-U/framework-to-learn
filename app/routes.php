 <?php

$router->get('', 'PagesController@home');
$router->get('about', 'PagesController@about');
$router->get('contact', 'PagesController@contact');
$router->get('users', 'UsersController@index');
$router->post('users', 'UsersController@store');
$router->get('users/{id}', 'UsersController@show');
$router->get('test', function(){
	echo "hello from a callable";
});