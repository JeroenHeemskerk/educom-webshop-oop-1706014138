<?php

class ModelFactory {
    private $crudFactory;

    public function __construct($crudFactory) {
        $this->crudFactory = $crudFactory;
    }

    public function createModel($type) {
        switch ($type) {
            case 'page':
                require_once('models/PageModel.php');
                $model = new PageModel(NULL);
                break;
            case 'user':
                require_once('models/UserModel.php');
                $model = new UserModel(NULL);
                break;
            case 'shop':
                require_once('models/ShopModel.php');
                $model = new ShopModel(NULL);
                break;
        }
    }
}

?>
