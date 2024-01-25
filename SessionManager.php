<?php
class SessionManager {
    function isUserLoggedIn() {
        return isset($_SESSION['name']);
        // || $_SESSION['name'] != NULL;
    }
    
    function loginUser($name, $userId) {
        $_SESSION['name'] = $name;
        $_SESSION['userId'] = $userId;
        $_SESSION['cart'] = array();
    }
    
    function logoutUser() {
        session_unset();
        session_destroy();
    }
    
    function getLoggedInUsername() {
        return isset($_SESSION['name']) ? $_SESSION['name'] : NULL;
    }

    function getLoggedInUserId() {
        return isset($_SESSION['userId']) ? $_SESSION['userId'] : NULL;
    }

    function addItemsToCart($productId, $quantity=1) {
        if (array_key_exists($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    function removeItemsFromCart($productId, $quantity=1) {
        if (array_key_exists($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][$productId] -= $quantity;
            if ($_SESSION['cart'][$productId] <= 0) {
                unset($_SESSION['cart'][$productId]);
            }
            return true;
        }
        return false;
    }

    function emptyCart() {
        $_SESSION['cart'] = array();
    }

    function getCartItems() {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : NULL;
    }
}

?>
