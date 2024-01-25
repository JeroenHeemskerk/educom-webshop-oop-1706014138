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
                $data = $this->model->validateContact();
                break;
            case 'login':
                $data = $this->model->validateLogin();
                if ($data['valid'] && !empty($data['connectionErr'])) {
                    loginUser($data['name'], $data['userId']);
                    $this->model->page = 'home';
                }
                break;
            case 'logout':
                logoutUser();
                $this->model->page = 'home';
                break;
            case 'register':
                require_once('register.php');
                try {
                    $data = $this->model->validateRegistration();
                    if ($data['valid']) {
                        $this->model->addUser($data);
                        $data['pass'] = ''; //remove pass, else it will be pre-filled
                        $this->model->page = 'login';
                    }
                }
                catch (Exception $ex) {
                    $data['connectionErr'] = "Er is een technische storing opgetreden, registratie is niet mogelijk. Probeer het later opnieuw.";

                    LogError("Authentication Failed: ".$ex->getMessage());
                }
                break;
            //... detail, webshop, etc
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
                require_once('views/HomeDoc.php');
                $view = new HomeDoc($this->model);
                break;
            case 'register':
                require_once('views/RegisterDoc.php');
                $view = new RegisterDoc($this->model);
                break;
            case 'login':
                require_once('views/LoginDoc.php');
                $view = new LoginDoc($this->model);
                break;
        }

        $view->show();
    }
}

?>
