<?php
    require_once("../views/LoginDoc.php");

    $email = $pass = $name = $userId = '';
    $emailErr = $passErr = $connectionErr = '';
    $valid = false;
    $data = array('valid'=>$valid, 'email'=>$email, 'pass'=>$pass, 'name'=>$name, 'userId'=>$userId,
                    'emailErr'=>$emailErr, 'passErr'=>$passErr, 'connectionErr'=>$connectionErr,
                    'page' => 'login', 'header' => 'Login Pagina');

    $view = new LoginDoc($data);
    $view->show();
?>