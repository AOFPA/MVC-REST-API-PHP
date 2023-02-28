<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");

$ROOT_PATH = str_replace("/api/user" , "" , __DIR__);
$CONTROLLER_PATH = $ROOT_PATH . '/controllers' ;

require_once($CONTROLLER_PATH . '/User/UserController.php');

$userController = new UserController();

$params = array();
$params['id'] = isset($_POST['id']) && !empty($_POST['id']) ? $_POST['id'] : "" ;

$data = json_encode($params);
$data = json_decode($data);

$userController->id = $data->id ;


if($data->id == ""){
    http_response_code(200);
    $arr = array();
    $arr['code'] = 204;
    $arr['status'] = 'error';
    $arr['message'] = "No id";

    echo json_encode($arr);
}else{
    if($userController->deleteUser()){
        http_response_code(200);
        $arr = array();
        $arr['code'] = 200;
        $arr['status'] = 'success';
        $arr['message'] = "deleted successfully";
        echo json_encode($arr);
    }else{
        http_response_code(200);
        $arr = array();
        $arr['code'] = 204;
        $arr['status'] = 'error';
        $arr['message'] = "sql error";
        echo json_encode($arr);
    }
}
?>