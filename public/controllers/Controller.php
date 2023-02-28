<?php 

/**
 * @OA\Info(title="My First API", version="0.1")
 */



class Controller
{
    private $db;

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
    }

    public function connection()
    {
        return $this->db;
    }

}


// $test = new BaseController(); 
// print_r($_ENV['HOST']);


?>