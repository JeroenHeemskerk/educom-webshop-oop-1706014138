<?php

class PageController {
    private $model;

    public function __construct() {
        require_once('models/PageModel.php');
        $this->model = new PageModel(NULL);
    }

    public function handleRequest() {
        $this->getRequest();
        $this->processRequest();
        $this->showResponse();
    }

    private function getRequest() {
        $this->model->getRequestedPage();
    }

    private function processRequest() {
        switch($this->model->page) {
            case 'contact':
                require_once('models/UserModel.php');
                $this->model = new UserModel($this->model);
                $data = $this->model->validateContact();
                break;
            case 'login':
                require_once('models/UserModel.php');
                $this->model = new UserModel($this->model);
                $this->model->validateLogin();
                if ($this->model->valid && empty($this->model->connectionErr)) {
                    $this->model->loginUser($this->model->name, $this->model->getUserId());
                    $this->model->page = 'home';
                }
                break;
            case 'logout':
                require_once('models/UserModel.php');
                $this->model = new UserModel($this->model);
                $this->model->logoutUser();
                $this->model->page = 'home';
                break;
            case 'register':
                require_once('models/UserModel.php');
                $this->model = new UserModel($this->model);
                try {
                    $this->model->validateRegistration();
                    if ($this->model->valid) {
                        $this->model->addUser($this->model->email, $this->model->name, $this->model->pass);
                        $this->model->pass = ''; //remove pass, else it will be pre-filled
                        $this->model->page = 'login';
                    }
                }
                catch (Exception $ex) {
                    $this->model->connectionErr = "Er is een technische storing opgetreden, registratie is niet mogelijk. Probeer het later opnieuw.";

                    LogError("Authentication Failed: ".$ex->getMessage());
                }
                break;
            case 'detail':
                try {
                    require_once('models/ShopModel.php');
                    $this->model = new ShopModel($this->model);
                    $this->model->handleCartActions();
                    $this->model->products = $this->model->getProducts([Util::getUrlVar('productId')]);
                }
                catch (Exception $ex) {
                    $this->model->connectionErr = "Er is een technische storing opgetreden, er kon geen verbinding gemaakt worden met de database. Probeer het later opnieuw.";

                    LogError("Authentication Failed: ".$ex->getMessage());
                }
                break;
            case 'webshop':
                try {
                    require_once('models/ShopModel.php');
                    $this->model = new ShopModel($this->model);
                    $this->model->handleCartActions();
                    $this->model->products = $this->model->getAllProducts();
                }
                catch (Exception $ex) {
                    $this->model->connectionErr = "Er is een technische storing opgetreden, er kon geen verbinding gemaakt worden met de database. Probeer het later opnieuw.";

                    LogError("Authentication Failed: ".$ex->getMessage());
                }
                break;
            case 'cart':
                try {
                    require_once('models/ShopModel.php');
                    $this->model = new ShopModel($this->model);
                    $this->model->handleCartActions();
                    $this->model->cartItems = $this->model->getCartItems();
                }
                catch (Exception $ex) {
                    $this->model->connectionErr = "Er is een technische storing opgetreden, er kon geen verbinding gemaakt worden met de database. Probeer het later opnieuw.";

                    LogError("Authentication Failed: ".$ex->getMessage());
                }
                break;
            case 'topfive':
                try {
                    require_once('models/ShopModel.php');
                    $this->model = new ShopModel($this->model);
                    $this->model->handleCartActions();
                    $this->model->products = $this->model->getTopFiveProducts();
                }
                catch (Exception $ex) {
                    $this->model->connectionErr = "Er is een technische storing opgetreden, er kon geen verbinding gemaakt worden met de database. Probeer het later opnieuw.";

                    LogError("Authentication Failed: ".$ex->getMessage());
                }
                break;
        }
    }

    private function showResponse() {
        $this->model->createMenu();

        switch ($this->model->page) {
            case 'home':
                require_once('views/HomeDoc.php');
                $view = new HomeDoc($this->model);
                break;
            case 'about':
                require_once('views/AboutDoc.php');
                $view = new AboutDoc($this->model);
                break;
            case 'contact':
                require_once('views/ContactDoc.php');
                $view = new ContactDoc($this->model);
                break;
            case 'register':
                require_once('views/RegisterDoc.php');
                $view = new RegisterDoc($this->model);
                break;
            case 'login':
                require_once('views/LoginDoc.php');
                $view = new LoginDoc($this->model);
                break;
            case 'detail':
                require_once('views/DetailDoc.php');
                $view = new DetailDoc($this->model);
                break;
            case 'webshop':
                require_once('views/WebshopDoc.php');
                $view = new WebshopDoc($this->model);
                break;
            case 'cart':
                require_once('views/CartDoc.php');
                $view = new CartDoc($this->model);
                break;
            case 'topfive':
                require_once('views/TopFiveDoc.php');
                $view = new TopFiveDoc($this->model);
                break;
        }

        $view->show();
    }
}

?>
