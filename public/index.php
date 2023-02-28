<?php 
use AltoRouter as Router;
require_once realpath(__DIR__ . "/vendor/autoload.php");
$router = new Router();

//end point
//read all user
$router->map( 'GET', '/api/v1/user', function() {
	require __DIR__ . '/api/user/get_all.php';
});

//create a new user
$router->map( 'POST', '/api/v1/user/create', function() {
	require __DIR__ . '/api/user/create.php';
});

//modify user
$router->map( 'POST', '/api/v1/user/update', function() {
	require __DIR__ . '/api/user/update.php';
});

//delete user
$router->map( 'POST', '/api/v1/user/delete', function() {
	require __DIR__ . '/api/user/delete.php';
});

//read one user
$router->map( 'GET', '/api/v1/user/[i:id]', function( $id ) {
	require __DIR__ . '/api/user/get_by_id.php';
});


$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	echo "error" ;
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}


?>