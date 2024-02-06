<?php

class RatingCrud {
    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createRating($userId, $productId, $rating) {
        $sql = 'INSERT INTO user_ratings (user_id, product_id, rating)
                VALUES (:user_id, :product_id, :rating)';

        $params = array();
        $params[':user_id'] = $userId;
        $params[':product_id'] = $productId;
        $params[':rating'] = $rating;
        return $this->crud->createRow($sql, $params);
    }

    public function readUserRating($userId, $productId) {
        $sql = 'SELECT rating
                FROM user_ratings
                WHERE user_id = :user_id AND product_id = :product_id';

        $params = array(':user_id'=>$userId, ':product_id'=>$productId);
        return $this->crud->readOneRow($sql, $params);
    }

    public function readAverageRating($productId) {
        $sql = 'SELECT product_id, AVG(rating) avg_rating
                FROM user_ratings
                WHERE product_id = :product_id';

        $params = array(':product_id'=>$productId);
        return $this->crud->readOneRow($sql, $params);
    }

    public function readAverageRatingForAllProducts() {
        $sql = 'SELECT id, IFNULL(avgs.avg_rating,0) as avg_rating
                FROM products
                LEFT JOIN (
                    SELECT product_id, AVG(rating) avg_rating
                    FROM user_ratings
                    GROUP BY product_id) avgs
                ON products.id = avgs.product_id';

        $params = array();
        return $this->crud->readMultipleRows($sql, $params);
    }

    public function updateRating($userId, $productId, $rating) {
        $sql = 'UPDATE user_ratings
                SET rating = :rating
                WHERE user_id = :user_id AND product_id = :product_id';

        $params = array();
        $params[':user_id'] = $userId;
        $params[':product_id'] = $productId;
        $params[':rating'] = $rating;
        return $this->crud->createRow($sql, $params);
    }
}

?>
