<?php 

/**
 * @OA\Info(
 *      title="My First API (Chokchai Jamnoi)", 
 *      version="1.0"
 * )
 */



class Controller
{
    private $db;
    public $key;

    public function __construct()
    {
        //เรียกใช้ autoLoad 
        $ROOT_PATH = str_replace("controllers" , "" , __DIR__);
        // echo $ROOT_PATH ;
        // echo __DIR__ ;
        
        require_once($ROOT_PATH . "/vendor/autoload.php");
        //เรียกใช้ Library dotenv
        $dotenv = Dotenv\Dotenv::createImmutable($ROOT_PATH);
        $dotenv->load();
        //connect database
        require_once($ROOT_PATH . "/config/Database.php");
        $database = new Database(
            $_ENV['HOST'],
            $_ENV['DATABASENAME'],
            $_ENV['USERNAME'],
            $_ENV['PASSWORD'],
            $_ENV['PORT']
        );

        $this->db = $database->connection();
        $this->key = $_ENV['JWT_KEY'];
    }

    public function connection()
    {
        return $this->db;
    }

    public function jwtKey()
    {
        return $this->key;
    }

}


// $test = new BaseController(); 
// print_r($_ENV['HOST']);


?>