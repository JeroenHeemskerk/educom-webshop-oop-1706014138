<?php
    define('RESULT_UNKNOWN_USER', 0);
    define('RESULT_INCORRECT_PASSWORD', 1);
    define('RESULT_OK', 2);

    function doesEmailExist($email) {
        require_once('db_repository.php');
        return !empty(getUserByEmail($email));
    }

    function authorizeUser($email, $pass) {
        require_once('db_repository.php');
        $user = getUserByEmail($email);
        
        if ($user == NULL) {
            $userData['user'] = NULL;
            $userData['result'] = RESULT_UNKNOWN_USER;
            return $userData;
        }
        if (!password_verify($pass, $user['password'])) {
            $userData['user'] = NULL;
            $userData['result'] = RESULT_INCORRECT_PASSWORD;
            return $userData;
        }
        $userData['user'] = $user;
        $userData['result'] = RESULT_OK;
        return $userData;
    }

    function addUser($data) {
        require_once('db_repository.php');
        $encrypted_password = password_hash($data['pass'], PASSWORD_BCRYPT, ['cost'=>14]);
        storeUser($data['email'], $data['name'], $encrypted_password);
    }
    
    function getProducts($ids) {
        require_once('db_repository.php');
        return getProductsByID($ids);
    }

    function getProductList() {
        require_once('db_repository.php');
        return getAllProducts();
    }

    function getTopFiveProducts() {
        require_once('db_repository.php');
        return getTopFive();
    }

    function placeOrder($userId, $cartItems) {
        require_once('db_repository.php');
        createOrder($userId, $cartItems);
    }
?>