<?php

define('CONNECTION_STRING', 'mysql:host=localhost;dbname=thomas_webshop');
define('USERNAME', 'thomas_webshop_user');
define('PASSWORD', 'didIturNoffThesToveBefoReil3fttHism0rniNg');

class Crud {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO(CONNECTION_STRING, USERNAME, PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createRow($sql, $params) {
        $stmt = $this->pdo->prepare($sql);
        foreach($params as $str=>$param) {
            $stmt->bindValue($str, $param);
        }
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function readOneRow($sql, $params) {
        $stmt = $this->pdo->prepare($sql);
        foreach($params as $str=>$param) {
            $stmt->bindValue($str, $param);
        }
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    public function readMultipleRows($sql, $params) {
        $stmt = $this->pdo->prepare($sql);
        foreach($params as $str=>$param) {
            $stmt->bindValue($str, $param);
        }
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function updateRow($sql, $params) {
        $stmt = $this->pdo->prepare($sql);
        foreach($params as $str=>$param) {
            $stmt->bindValue($str, $param);
        }
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->execute();
    }

    public function deleteRow($sql, $params) {
        $stmt = $this->pdo->prepare($sql);
        foreach($params as $str=>$param) {
            $stmt->bindValue($str, $param);
        }
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->execute();
    }
}

?>
