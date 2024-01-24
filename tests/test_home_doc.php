<?php
    require_once("../views/HomeDoc.php");

    $data = array('page' => 'home', 'header' => 'Home Pagina');
    $view = new HomeDoc($data);
    $view->show();
?>