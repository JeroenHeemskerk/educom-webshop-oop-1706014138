<?php
    require_once("../views/WebshopDoc.php");

    $data = array('products'=>[], 'page' => 'webshop', 'header' => 'Appel Store');

    $view = new WebshopDoc($data);
    $view->show();
?>