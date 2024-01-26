<?php

require_once('models/PageModel.php');

class ShopModel extends PageModel {
    public $cartItems = array();
    public $products = array();

    public function __construct($pageModel) {
        PARENT::__construct($pageModel);
    }

    public function getLoggedInUserId() {
        return $this->sessionManager->getLoggedInUserId();
    }

    public function addItemsToCart($productId, $quantity=1) {
        $this->sessionManager->addItemsToCart($productId, $quantity);
    }

    public function removeItemsFromCart($productId, $quantity=1) {
        $this->sessionManager->removeItemsFromCart($productId, $quantity);
    }

    public function emptyCart() {
        $this->sessionManager->emptyCart();
    }

    public function getCartItems() {
        return $this->sessionManager->getCartItems();
    }

    public function handleCartActions() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = Util::getPostVar('action');
            switch ($action) {
                case 'addToCart':
                    $quantity = (int)Util::getPostVar('quantity');
                    $productId = Util::getPostVar('productId');
                    $this->addItemsToCart($productId, $quantity);
                    break;
                case 'removeFromCart':
                    $quantity = (int)Util::getPostVar('quantity');
                    $productId = Util::getPostVar('productId');
                    $this->removeItemsFromCart($productId, $quantity);
                    break;
                case 'placeOrder':
                    $userId = $this->getLoggedInUserId();
                    $cartItems = $this->getCartItems();
                    $this->placeOrder($userId, $cartItems);
                    $this->emptyCart();
                    break;
            }
        }
    }

    public function getProducts($ids) {
        require_once('db_repository.php');
        return getProductsByID($ids);
    }

    public function getAllProducts() {
        require_once('db_repository.php');
        return getAllProducts();
    }

    public function getTopFiveProducts() {
        require_once('db_repository.php');
        return getTopFive();
    }

    public function placeOrder($userId, $cartItems) {
        require_once('db_repository.php');
        createOrder($userId, $cartItems);
    }

}

?>
