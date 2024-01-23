<?php

    require_once('../views/BasicDoc.php');

    $data = array('page' => 'basic', 'header' => 'TESTING TESTING 123');

    $view = new BasicDoc($data);
    $view->show();
?>