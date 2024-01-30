<?php

class CrudFactory {
    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createCrud($type) {
        switch ($type) {
            case 'user':
                require_once('UserCrud.php');
                $userCrud = new UserCrud($this->crud);
                return $userCrud;
                break;
            case 'shop':
                require_once('ShopCrud.php');
                $ShopCrud = new ShopCrud($this->crud);
                return $ShopCrud;
                break;
        }
    }
}

?>
