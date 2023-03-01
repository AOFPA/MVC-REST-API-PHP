<?php 

$CONTROLLER_PATH = str_replace("/User", "" , __DIR__);
//C:\xampp\htdocs\php-api
require_once($CONTROLLER_PATH . '/Controller.php');


class UserController extends Controller
{
        private $db; 
        private $result; 
        public $id; 
        public $fname; 
        public $lname;

        public function __construct()
        {
            //connect to database
            parent::__construct();
            $this->db = $this->connection();
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
         *     @OA\Response(response="400", description="Bad Request")
         * )
         */

        public function getUserAll()
        {
            $this->result = null; 
            try{
                $userModel = new UserModel($this->db);
                $this->result = $userModel->getAll();
            }catch(PDOException $e){
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
         *     @OA\Response(response="400", description="Bad Request")
         * )
         */
        public function getUserById()
        {
            $this->result = null; 
            
            try{
                $userModel = new UserModel($this->db);
                $userModel->id = $this->id ;
                $this->result = $userModel->getById();
                
            }catch(PDOException $e){
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
         *           @OA\Schema(required={"fname","lname"},
         *              @OA\Property(property="fname", type="string", example="John"),
         *              @OA\Property(property="lname", type="string", example="Doe")
         *            )
         *         )    
         *     ) ,       
         *     @OA\Response(response="200", description="Success Request"),
         *     @OA\Response(response="400", description="Bad Request")
         * )
         */

        public function createUser()
        {
            $this->result = null; 
            try{
                $userModel = new UserModel($this->db);
                $userModel->fname = $this->fname ;
                $userModel->lname = $this->lname ;
                $this->result = $userModel->insert();
            }catch(PDOException $e){
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
         *           @OA\Schema(required={"fname","lname"},
         *              @OA\Property(property="fname", type="string", example="John"),
         *              @OA\Property(property="lname", type="string", example="Doe")
         *            )
         *         )    
         *     ) ,   
         *     @OA\Response(response="200", description="Success Request"),
         *     @OA\Response(response="400", description="Bad Request")
         * )
         */
        public function updateUser()
        {
            $this->result = null; 
            
            try{
                $userModel = new UserModel($this->db);
                $userModel->id = $this->id ;
                $userModel->fname = $this->fname ;
                $userModel->lname = $this->lname ;
                $this->result = $userModel->update();
                
            }catch(PDOException $e){
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
         *     @OA\Response(response="400", description="Bad Request")
         * )
         */
        
        public function deleteUser()
        {
            $this->result = null; 
            
            try{
                $userModel = new UserModel($this->db);
                $userModel->id = $this->id ;
                $this->result = $userModel->delete();
                
            }catch(PDOException $e){
                $this->result = false; 
            }
            return $this->result ;
        }

}


?>