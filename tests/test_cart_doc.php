<?php
    require_once("../views/CartDoc.php");

    $data = array('cartItems'=>[], 'page' => 'cart', 'header' => 'Shopping Cart');

    $view = new CartDoc($data);
    $view->show();
?>