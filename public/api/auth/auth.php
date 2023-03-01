<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");

$ROOT_PATH = str_replace("/api/auth" , "" , __DIR__);
$CONTROLLER_PATH = $ROOT_PATH . '/controllers' ;

require_once($CONTROLLER_PATH . '/Auth/AuthController.php');

$authController = new AuthController();

$params = array();
$params['phone'] = isset($_POST['phone']) && !empty($_POST['phone']) ? $_POST['phone'] : "" ;

$data = json_encode($params);
$data = json_decode($data);

$authController->phone = $data->phone ;


if($data->phone == ""){
    http_response_code(200);
    $arr = array();
    $arr['code'] = 204;
    $arr['status'] = 'error';
    $arr['message'] = "No phone";

    echo json_encode($arr);
}else{
    if( !empty($authController->auth())){
        http_response_code(200);
        $arr = array();
        $arr['response'] = $authController->auth() ;
        $arr['code'] = 200;
        $arr['status'] = 'success';
        $arr['message'] = "authorization successfully";

        echo json_encode($arr);
    }else{
        http_response_code(200);
        $arr = array();
        $arr['code'] = 204;
        $arr['status'] = 'error';
        $arr['message'] = "error try again";
        
        echo json_encode($arr);
    }
}
?>