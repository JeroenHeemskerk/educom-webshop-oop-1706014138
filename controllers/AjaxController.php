<?php

class AjaxController {
    private $modelFactory;
    private $model;

    private $function;
    private $args;

    public function __construct($modelFactory, $ajaxInput) {
        $this->modelFactory = $modelFactory;
        $this->model = $this->modelFactory->createModel('rating');
        $this->function = $ajaxInput['function'];
        $this->args = $ajaxInput;
        unset($this->args['function']);
    }

    public function processRequest() {
        $result = $this->handleAction();
        require_once('views/AjaxView.php');
        $view = new AjaxView($result);
        $view->show();
    }

    private function handleAction() {
        switch ($this->function) {
            case 'getRating':
                $productId = $this->args['productId'];
                return $this->model->readAverageRating($productId);
                break;
            case 'getAllRatings':
                return $this->model->readAverageRatingForAllProducts();
                break;
            case 'sendRating':
                $userId = $this->args['userId'];
                $productId = $this->args['productId'];
                $rating = $this->args['rating'];
                if (empty($this->model->hasUserRatedProduct($userId, $productId))) {
                    $this->model->updateRating($userId, $productId, $rating);
                } else {
                    $this->model->createRating($userId, $productId, $rating);
                }
                break;

        }
    }
}

?>
