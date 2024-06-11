<?php



namespace Libs;

use PDO;

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public $conn;
    
    
    
    
    public function __construct() {
      $this->servername   =    SEVERNAME;
      $this->username     =    USERNAME;
      $this->password     =    PASS;
      $this->dbname       =    DBNAME;
    }
  
    public function connect() {
      try {
          $this->conn = new PDO(
          "mysql:host=".$this->servername.";dbnafbv me=".$this->dbname.
          ";charset=utf8", $this->username, $this->password);

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(!$this->conn){
          echo "NO CONECTADO";
        }
       
      } catch(PDOException $e) {
        echo "Error al conectar: " . $e->getMessage();
      }

      return $this->conn; 
    }
  
    public function getConn() {
      return $this->conn;
    }

    public function close() {
      $this->conn = null;
    }



/* queries */


public function all($table,$type=PDO::FETCH_ASSOC){
  $sql = "SELECT * FROM ". $table ;
  $stmt = $this->conn->prepare($sql);
  $stmt->execute();
  $result=$stmt->fetchAll($type);
  return $result;
}

public function whereId($table,$pname,$param,$type=PDO::FETCH_ASSOC){
  $sql = "SELECT * FROM ".$table ." WHERE " . $pname ."=" .$param;
  $stmt = $this->conn->prepare($sql);
  $stmt->execute();
  $result=$stmt->fetch($type);
  return $result;
}

public function where($table,$param1,$param2,$type=PDO::FETCH_ASSOC){
 $sql = "SELECT * FROM ".$table ." WHERE " . $param1 ."=:value";
  $stmt = $this->conn->prepare($sql);
  $stmt->execute([":value"=>$param2]);
  $result=$stmt->fetch($type);
  return $result;
}
public function whereAnd($table,$param1,$param2,$p1,$val,$type=PDO::FETCH_ASSOC){
 $sql = "SELECT * FROM ".$table ." WHERE " . $param1 ."=:value AND ".$p1."!=:value2";
  $stmt = $this->conn->prepare($sql);
  $stmt->execute([":value"=>$param2,":value2"=>$val]);
  $result=$stmt->fetch($type);
  return $result;
}
public function insert($sql,array $data){

try {
    $stmt = $this->conn->prepare($sql);
  $stmt->execute($data);
  $stmt->closeCursor();
  $insertId=$this->conn->lastInsertId();
  $response =  $insertId;
} catch (Exception $e) {
  $response = $e->getMessage();
}
return $response ;

}
public function update($sql,array $data){

try {
    $stmt = $this->conn->prepare($sql);
  $stmt->execute($data);
  $stmt->closeCursor();
  $response = $data;

} catch (Exception $e) {
  $response = $e->getMessage();
}
  return $response ;

}

public function delete($table,$pname,$id){
  $sql = "DELETE FROM ". $table ." WHERE " . $pname ."=" .$id;
  $stmt = $this->conn->prepare($sql);
  $stmt->execute();
  $result=$stmt;
  return $result;
}
public function upload($table,$column,$param,$value){
    $sql="UPDATE " .  $table." SET " .$column." WHERE " .$param."=:value";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([":value"=>$value]);
    $result=$stmt;
    return $result;
}
public function upload2($sql,array $data){
try {
    $stmt = $this->conn->prepare($sql);
  $stmt->execute($data);
  $stmt->closeCursor();
  $response = $data;

} catch (Exception $e) {
  $response = $e->getMessage();
}
  return $response ;
}

  }
  