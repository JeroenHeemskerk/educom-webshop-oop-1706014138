<?php
    require_once("../views/AboutDoc.php");

    $data = array('page' => 'about', 'header' => 'About Pagina');
    $view = new AboutDoc($data);
    $view->show();
?>