<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('controllers/PageController.php');
    require_once('Crud.php');
    require_once('CrudFactory.php');
    require_once('ModelFactory.php');


    $crud = new Crud();
    $crudFactory = new CrudFactory($crud);
    $modelFactory = new ModelFactory($crudFactory);

    $controller = new PageController($modelFactory);
    $controller->handleRequest();

    //function to simulate logging error messages
    function LogError($msg) {
        echo "Logging to server: $msg";
    }
?>