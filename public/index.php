<?php 
use AltoRouter as Router;
require_once realpath(__DIR__ . "/vendor/autoload.php");
$router = new Router();

//end point
$router->map( 'GET', '/api/v1/user', function() {
	require __DIR__ . '/api/user/get_all.php';
});

$router->map( 'POST', '/api/v1/user/create', function() {
	require __DIR__ . '/api/user/create.php';
});

$router->map( 'POST', '/api/v1/user/update', function() {
	require __DIR__ . '/api/user/update.php';
});



$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	echo "error" ;
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}


?>