<?php 
$CONTROLLER_PATH = str_replace("/User", "" , __DIR__);
//C:\xampp\htdocs\php-api
require_once($CONTROLLER_PATH . '/Controller.php');

//เรียกใช้ autoLoad 
$ROOT_PATH = str_replace("controllers/User" , "" , __DIR__);
require_once($ROOT_PATH . "/vendor/autoload.php");

// use JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class UserController extends Controller
{
        private $db; 
        private $result; 
        public $id; 
        public $fname; 
        public $lname;
        public $phone;

        private $key ;

        public function __construct()
        {
            //connect to database
            parent::__construct();
            $this->db = $this->connection();
            $this->key = $this->jwtKey();
            //call model
            $MODEL_PATH = str_replace("/controllers/User" , "" , __DIR__);
            require_once($MODEL_PATH .  '/model/UserModel.php');
        }


        /**
         * @OA\Get(
         *     path="/api/v1/user",
         *     tags={"User"},
         *     description="Read All Users",
         *     @OA\Response(response="200", description="Success Request"),
         *     @OA\Response(response="400", description="Bad Request"),
         *     security={{ "bearerAuth":{} }}
         * )
         */

        public function getUserAll()
        {
            $header = apache_request_headers(); //รับ auth header


            $this->result = null; 

            if($header["Authorization"]){
                $token = str_replace('Bearer ' , '' , $header["Authorization"]);
                try{
                    $token = JWT::decode($token,new Key($this->key , 'HS256'));
                    $userModel = new UserModel($this->db);
                    $this->result = $userModel->getAll();
                }catch(PDOException $e){
                    $this->result = false ;
                }
            }else{
                $this->result = false ;
            }

            
            
            return $this->result ;
        }

         /**
         * @OA\GET(
         *     path="/api/v1/user/{id}",
         *     tags={"User"},
         *     description="Read Users By ID",
         *     @OA\Parameter(
         *         name="id",
         *         required=true,
         *         in="path",
         *         @OA\Schema(
         *            type="integer"
         *         )
         *     ) ,       
         *     @OA\Response(response="200", description="Success Request"),
         *     @OA\Response(response="400", description="Bad Request"),
         *     security={{ "bearerAuth":{} }}
         * 
         * )
         */
        public function getUserById()
        {
            $header = apache_request_headers(); //รับ auth header
            $this->result = null; 
            
            if($header["Authorization"]){
                $token = str_replace('Bearer ' , '' , $header["Authorization"]);
                try{
                    $token = JWT::decode($token,new Key($this->key , 'HS256'));
                    $userModel = new UserModel($this->db);
                    $userModel->id = $this->id ;
                    $this->result = $userModel->getById();
                    
                }catch(PDOException $e){
                    $this->result = false; 
                }
            }else{
                $this->result = false; 
            }
            
            return $this->result ;
        }

        

         /**
         * @OA\POST(
         *     path="/api/v1/user/create",
         *     tags={"User"},
         *     description="Add Users",
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
         *     @OA\Response(response="400", description="Bad Request"),
         *     security={{ "bearerAuth":{} }}
         * )
         */

        public function createUser()
        {
            $header = apache_request_headers(); //รับ auth header
            $this->result = null; 

            if($header["Authorization"]){
                $token = str_replace('Bearer ' , '' , $header["Authorization"]);
                try{
                    $token = JWT::decode($token,new Key($this->key , 'HS256'));
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
            }else{
                $this->result = false; 
            }
            
            return $this->result ;
        }

        /**
         * @OA\POST(
         *     path="/api/v1/user/{id}/update",
         *     tags={"User"},
         *     description="Edit Users",
         *     @OA\Parameter(
         *         name="id",
         *         required=true,
         *         in="path",
         *         @OA\Schema(
         *            type="integer"
         *         )
         *     ) , 
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
         *     @OA\Response(response="400", description="Bad Request"),
         *     security={{ "bearerAuth":{} }}
         * )
         */
        public function updateUser()
        {
            $header = apache_request_headers(); //รับ auth header
            $this->result = null; 
            if($header["Authorization"]){
                $token = str_replace('Bearer ' , '' , $header["Authorization"]);
                try{
                    $token = JWT::decode($token,new Key($this->key , 'HS256'));
                
                    $userModel = new UserModel($this->db);
                    $userModel->id = $this->id ;
                    $userModel->fname = $this->fname ;
                    $userModel->lname = $this->lname ;
                    $userModel->phone = $this->phone ;
    
                    $stmt = $userModel->getByPhone();
                    if($stmt){
                        $count = $stmt->rowCount();
                        if($count == 0){
                            $this->result = $userModel->update();
                        }else{
                            $rs = $stmt->fetch();
                            if($rs['id'] == $this->id){
                                $this->result = $userModel->update();
                            }else{
                                $this->result = false;
                            }
                        }
                    }else{
                        $this->result = false; 
                    }       
                    
                }catch(PDOException $e){
                    $this->result = false; 
                }
            }else{
                $this->result = false; 
            }
           
            return $this->result ;
        }

       
        /**
         * @OA\POST(
         *     path="/api/v1/user/{id}/delete",
         *     tags={"User"},
         *     description="Delete User",
         *     @OA\Parameter(
         *         name="id",
         *         required=true,
         *         in="path",
         *         @OA\Schema(
         *            type="integer"
         *         )
         *     ) ,       
         *     @OA\Response(response="200", description="Success Request"),
         *     @OA\Response(response="400", description="Bad Request"),
         *     security={{ "bearerAuth":{} }}
         * )
         */
        
        public function deleteUser()
        {
            $header = apache_request_headers(); //รับ auth header
            $this->result = null; 
            if($header["Authorization"]){
                $token = str_replace('Bearer ' , '' , $header["Authorization"]);
                try{
                    $token = JWT::decode($token,new Key($this->key , 'HS256'));
                    $userModel = new UserModel($this->db);
                    $userModel->id = $this->id ;
                    $this->result = $userModel->delete();
                    
                }catch(PDOException $e){
                    $this->result = false; 
                }
            }else{
                $this->result = false; 
            }
            
            return $this->result ;
        }

}


?>