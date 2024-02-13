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
        $stmt = $this->prepareAndBind($sql, $params);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function readOneRow($sql, $params) {
        $stmt = $this->prepareAndBind($sql, $params);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    public function readMultipleRows($sql, $params) {
        $stmt = $this->prepareAndBind($sql, $params);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    public function updateRow($sql, $params) {
        return $this->prepareAndBind($sql, $params)->execute();
    }

    public function deleteRow($sql, $params) {
        return $this->prepareAndBind($sql, $params)->execute();
    }

    private function prepareAndBind($sql, $params) {
        foreach($params as $key => $value) {
            if (!is_array($value)) {
               continue; // Not an array, skip this key
            }
   
            $sql_replacement = '';
   
            foreach($value as $index => $content) {
               $new_key = $key . "_" . $index; // creates "ids_0"
               if (!empty($sql_replacement)) {
                  $sql_replacement .=  ", ";
               }  
               $sql_replacement .= ":" . $new_key; // ":ids_0, :ids_1"
               $params[$new_key] = $content; // add a new parameter
            }
   
             $sql = str_replace(":" . $key, $sql_replacement, $sql); // replace het text ":ids" in de sql string met ":ids_0, :ids1"
             unset($params[$key]); // remove the array
        }

        $stmt = $this->pdo->prepare($sql);
        foreach($params as $str=>$param) {
            $stmt->bindValue($str, $param);
        }
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt;
    }
}

?>
