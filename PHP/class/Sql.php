<?php
class Sql extends PDO{
    private $conn;
    public function  __construct(){
        $this->conn = new PDO("mysql:dbname=loja_hardware;host=localhost","paulo","12345");
    }
    public function query($rawQuery, $params = array()){
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt;
    }
    public function setParams($statment, $parameters = array()){
        foreach ($parameters as $key => $value) {
            $this->setParam($statment, $key, $value);
        }
    }
    public function setParam($statment, $key, $value){
        $statment->bindParam($key, $value);
    }
    public function select($rawQuery, $params = array()){
        $stmt = $this->query($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function returnLastId(){
        $stmt = $this->conn;
        return $stmt->lastInsertID();
    }
}

?>