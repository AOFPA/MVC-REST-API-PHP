<?php 

$CONTROLLER_PATH = str_replace("/User", "" , __DIR__);
//C:\xampp\htdocs\php-api
require_once($CONTROLLER_PATH . '/Controller.php');


class UserController extends Controller
{
        private $db; 
        private $result; 
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

}


?>