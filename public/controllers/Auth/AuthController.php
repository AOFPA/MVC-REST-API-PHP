<?php

$CONTROLLER_PATH = str_replace("/Auth", "" , __DIR__);
require_once($CONTROLLER_PATH . '/Controller.php');


//เรียกใช้ autoLoad 
$ROOT_PATH = str_replace("controllers/Auth" , "" , __DIR__);
require_once($ROOT_PATH . "/vendor/autoload.php");

// use JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthController extends Controller
{
    private $db;
    private $key;
    private $result ;

    public function __construct()
    {
        //connect to database
        parent::__construct();
        $this->db = $this->connection();
        $this->key = $this->jwtKey();
        //call model
        $MODEL_PATH = str_replace("/controllers/Auth" , "" , __DIR__);
        require_once($MODEL_PATH .  '/model/UserModel.php');
    }

    public function auth()
    {
        $this->result = null ;
        
        try{
            $iat = time();
            $exp = $iat + 60*60 ; // 1 hour
            $payload = [
                'iss' => 'http://localhost:8080/', //เจ้าของ
                'aud' => 'http://localhost:8080/', //ผู้รับ
                'iat' => $iat,
                'exp' => $exp
            ];
            $jwt = JWT::encode($payload, $this->key, 'HS256');
            
            
        }catch(PDOException $e){
            $this->result = false ;
        }
    }
    
}


?>