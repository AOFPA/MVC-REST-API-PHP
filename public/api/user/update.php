<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");

$ROOT_PATH = str_replace("/api/user" , "" , __DIR__);
$CONTROLLER_PATH = $ROOT_PATH . '/controllers' ;

require_once($CONTROLLER_PATH . '/User/UserController.php');

$userController = new UserController();

$params = array();
$params['id'] = isset($id) && !empty($id) ? $id : "" ;
$params['fname'] = isset($_POST['fname']) && !empty($_POST['fname']) ? $_POST['fname'] : "" ;
$params['lname'] = isset($_POST['lname']) && !empty($_POST['lname']) ? $_POST['lname'] : "" ;
$params['phone'] = isset($_POST['phone']) && !empty($_POST['phone']) ? $_POST['phone'] : "" ;

$data = json_encode($params);
$data = json_decode($data);

$userController->id = $data->id ;
$userController->fname = $data->fname ;
$userController->lname = $data->lname ;
$userController->phone = $data->phone ;

if($data->fname == ""){
    http_response_code(200);
    $arr = array();
    $arr['code'] = 204;
    $arr['status'] = 'error';
    $arr['message'] = "No fname";

    echo json_encode($arr);
}else if($data->lname == ""){
    http_response_code(200);
    $arr = array();
    $arr['code'] = 204;
    $arr['status'] = 'error';
    $arr['message'] = "No lname";

    echo json_encode($arr);
}else if($data->phone == ""){
    http_response_code(200);
    $arr = array();
    $arr['code'] = 204;
    $arr['status'] = 'error';
    $arr['message'] = "No phone";

    echo json_encode($arr);
}else if($data->id == ""){
    http_response_code(200);
    $arr = array();
    $arr['code'] = 204;
    $arr['status'] = 'error';
    $arr['message'] = "No id";

    echo json_encode($arr);
}else{
    if($userController->updateUser()){
        http_response_code(200);
        $arr = array();
        $arr['code'] = 200;
        $arr['status'] = 'success';
        $arr['message'] = "updated successfully";
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