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
    private $result ;
    
    public $key;
    public $phone;
    public $fname;
    public $lname;

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

       /**
         * @OA\POST(
         *     path="/api/v1/auth",
         *     tags={"Authoriztion"},
         *     description="Get Token",
         *     @OA\RequestBody(
         *         @OA\MediaType(
         *            mediaType="multipart/form-data",
         *           @OA\Schema(required={"phone"},
         *              @OA\Property(property="phone", type="string", example="0811811811")
         *            )
         *         )    
         *     ) ,       
         *     @OA\Response(response="200", description="Success Request"),
         *     @OA\Response(response="400", description="Bad Request")
         * )
         */

    public function auth()
    {
        $this->result = null ;
        
        try{

            $userModel = new UserModel($this->db);
            
            $userModel->phone = $this->phone ;
            $stmt = $userModel->getByPhone();
            
            if($stmt){
                $count = $stmt->rowCount();
                if($count > 0){
                    $iat = time();
                    $exp = $iat + 60*60 ; // 1 hour
                    $payload = [
                        'iss' => 'http://localhost:8080/', //เจ้าของ
                        'aud' => 'http://localhost:8080/', //ผู้รับ
                        'iat' => $iat,
                        'exp' => $exp
                    ];
                    $jwt = JWT::encode($payload, $this->key, 'HS256');
                    $this->result = array(
                        'token'=>$jwt,
                        'expires'=>$exp
                    );
                }else{
                    $this->result = false; 
                }
            }else{
                $this->result = false; 
            }
            
        }catch(PDOException $e){
            $this->result = false ;
        }

        return $this->result ;
    }


    /**
         * @OA\POST(
         *     path="/api/v1/register",
         *     tags={"Authoriztion"},
         *     description="Register",
         *     @OA\RequestBody(
         *         @OA\MediaType(
         *            mediaType="multipart/form-data",
         *           @OA\Schema(required={"fname","lname","phone"},
         *              @OA\Property(property="fname", type="string", example="John"),
         *              @OA\Property(property="lname", type="string", example="Doe"),
         *              @OA\Property(property="phone", type="string", example="0811811811")
         *            )
         *         )    
         *     ) ,       
         *     @OA\Response(response="200", description="Success Request"),
         *     @OA\Response(response="400", description="Bad Request")
         * )
         */
    public function register()
    {
        $this->result = null; 
        try{
            $userModel = new UserModel($this->db);
            $userModel->fname = $this->fname ;
            $userModel->lname = $this->lname ;
            $userModel->phone = $this->phone ;

            $stmt = $userModel->getByPhone();
            if($stmt){
                $count = $stmt->rowCount();
                if($count == 0){
                    $this->result = $userModel->insert();
                }else{
                    $this->result = false; 
                }
            }else{
                $this->result = false; 
            }

            
        }catch(PDOException $e){
            $this->result = false; 
        }
        return $this->result ;
    }
    
}


?>