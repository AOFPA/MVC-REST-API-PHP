<?php

class UserModel
{


    private $conn ; 
    private $table = 'users' ;
    public $id ;
    public $fname ;
    public $lname ;


    
    public function __construct($db)
    {
        $this->conn = $db ;
    }



    public function getAll()
    {
        $table = $this->table ;
        try{
            $sql = "SELECT * FROM $table";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt ;

        }catch(PDOException $e){
            return false ;
        }
    }

    public function getById()
    {
        $table = $this->table ;
        try{
            $sql = "SELECT * FROM $table WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1,$this->id);
            $stmt->execute();
            return $stmt ;

        }catch(PDOException $e){
            return false ;
        }
    }


    public function insert()
    {
        $table = $this->table ;
        try{
            $sql = "INSERT INTO $table (`fname`, `lname`) VALUES (?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1,$this->fname);
            $stmt->bindParam(2,$this->lname);
            if($stmt->execute()){
                return true ;
            }else{
                return false ;
            }
        }catch(PDOException $e){
            return false ;
        }
    }



    public function update()
    {
        $table = $this->table ;
        try{
            $sql = "UPDATE $table SET `fname`=?,`lname`=? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1,$this->fname);
            $stmt->bindParam(2,$this->lname);
            $stmt->bindParam(3,$this->id);
            if($stmt->execute()){
                return true ;
            }else{
                return false ;
            }
        }catch(PDOException $e){
            return false ;
        }
    }

    public function delete()
    {
        $table = $this->table ;
        try{
            $sql = "DELETE FROM $table WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1,$this->id);
            if($stmt->execute()){
                return true ;
            }else{
                return false ;
            }
        }catch(PDOException $e){
            return false ;
        }
    }




    
}