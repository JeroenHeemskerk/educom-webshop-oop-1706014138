<?php

require_once('models/PageModel.php');

class RatingModel extends PageModel {
    private $function;
    private $args;

    private $ratingCrud;

    public function __construct($crud) {
        PARENT::__construct(NULL);
        $this->ratingCrud = $crud;
    }

    public function createRating($userId, $productId, $rating) {
        return $this->ratingCrud->createRating($userId, $productId, $rating);
    }

    public function readAverageRating($productId) {
        return $this->ratingCrud->readAverageRating($productId);
    }

    public function readAverageRatingForAllProducts() {
        return $this->ratingCrud->readAverageRatingForAllProducts();
    }

    public function updateRating($userId, $productId, $rating) {
        return $this->ratingCrud->updateRating($userId, $productId, $rating);
    }

    public function hasUserRatedProduct($userId, $productId) {
        return !empty($this->ratingCrud->readUserRating($userId, $productId));
    }

    public function getLoggedInUserId() {
        return $this->sessionManager->getLoggedInUserId();
    }
}

?>
