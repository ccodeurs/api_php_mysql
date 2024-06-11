<?php

namespace Libs;

use PDO;

class Databases {
    private static $servername;
    private static $username;
    private static $password;
    private static $dbname;
    private static $conn;

    public static function init($servername, $username, $password, $dbname) {
        self::$servername = $servername;
        self::$username = $username;
        self::$password = $password;
        self::$dbname = $dbname;
    }

    public static function connect() {
        try {
            self::$conn = new PDO(
                "mysql:host=".self::$servername.";dbname=".self::$dbname.";charset=utf8",
                self::$username,
                self::$password
            );

            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             if(!self::$conn){
          echo "NO CONECTADO";
        }
            return self::$conn;


        } catch(PDOException $e) {
            echo "Error al conectar: " . $e->getMessage();
            return null;
        }
    }

    public static function getConn() {
        return self::$conn;
    }

    public static function close() {
        self::$conn = null;
    }
 public static function get($sql,$data, $type=PDO::FETCH_ASSOC) {

        $stmt = self::$conn->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchAll($type);
        return $result;
    }
    public static function all($sql, $type=PDO::FETCH_ASSOC) {

        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll($type);
        return $result;
    }

    public static function whereId($table, $pname, $param, $type=PDO::FETCH_ASSOC) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $pname . " = ?";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$param]);
        $result = $stmt->fetch($type);
        return $result;
    }

    public static function where($table, $param1, $param2, $type=PDO::FETCH_ASSOC) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $param1 . " = ?";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$param2]);
        $result = $stmt->fetch($type);
        return $result;
    }

    public static function whereAnd($table, $param1, $param2, $p1, $val, $type=PDO::FETCH_ASSOC) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $param1 . " = ? AND " . $p1 . " != ?";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$param2, $val]);
        $result = $stmt->fetch($type);
        return $result;
    }

    public static function insert($sql, array $data) {
        try {
            $stmt = self::$conn->prepare($sql);
            $stmt->execute($data);
            $stmt->closeCursor();
            $insertId = self::$conn->lastInsertId();
            $response = $insertId;
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }

    public static function update($sql, array $data) {
        try {
            $stmt = self::$conn->prepare($sql);
            $stmt->execute($data);
            $stmt->closeCursor();
            $response = $data;
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }

    public static function delete($table, $pname, $id) {
        $sql = "DELETE FROM " . $table . " WHERE " . $pname . " = ?";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt;
        return $result;
    }
    public static function softDelete($sql, $id) {
        
        $stmt = self::$conn->prepare($sql);
        $stmt->execute($id);
        $result = $stmt;
        return $result;
    }

    public static function upload($table, $column, $param, $value) {
        $sql = "UPDATE " . $table . " SET " . $column . " WHERE " . $param . " = ?";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$value]);
        $result = $stmt;
        return $result;
    }

    public static function upload2($sql, array $data) {
        try {
            $stmt = self::$conn->prepare($sql);
            $stmt->execute($data);
            $stmt->closeCursor();
            $response = $data;
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
    public static function search($table, $tname, $search)
    {
        $sql = "SELECT * FROM $table WHERE $tname LIKE :search";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute(['search' => "%$search%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function searchData($sql, array $data)
    {
        
        $stmt = self::$conn->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
