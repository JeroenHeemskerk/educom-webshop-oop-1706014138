<?php

class CrudFactory {
    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createCrud($type) {
        $crud = NULL;
        switch ($type) {
            case 'user':
                require_once('UserCrud.php');
                $crud = new UserCrud($this->crud);
                break;
            case 'shop':
                require_once('ShopCrud.php');
                $crud = new ShopCrud($this->crud);
                break;
        }
        return $crud;
    }
}

?>
