<?php

class UserCrud {
    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createUser($email, $name, $password) {
        $sql = 'INSERT INTO users (email, name, password)
        VALUES (:email, :name, :password)';

        $params = array();
        $params[':email'] = $email;
        $params[':name'] = $name;
        $params[':password'] = $password;
        return $this->crud->createRow($sql, $params);
    }

    public function readUserByEmail($email) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $params = array(':email'=>$email);
        return $this->crud->readOneRow($sql, $params);
    }

    public function updateUser($email, $name, $password) {
        $sql = 'UPDATE users
                SET email = :email, name = :name, password = :password
                WHERE id = :id';

        $params = array();
        $params[':email'] = $email;
        $params[':name'] = $name;
        $params[':password'] = $password;
        return $this->crud->updateRow($sql, $params);
    }

    public function deleteUser($id) {
        $sql = 'DELETE FROM users WHERE id = :id';
        $params = array(':id'=>$id);
        return $this->crud->deleteRow($sql, $params);
    }
}

?>
