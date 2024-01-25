<?php
    require_once("../views/TopFiveDoc.php");

    $data = array('products'=>[], 'page' => 'topfive', 'header' => 'Top 5 Appels van de Week');

    $view = new TopFiveDoc($data);
    $view->show();
?>