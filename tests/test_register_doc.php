<?php
    require_once("../views/RegisterDoc.php");

    $name = $email = $pass = $passConfirm = '';
    $nameErr = $emailErr = $passErr = $passConfirmErr = '';
    $valid = false;
    $data = array('valid'=>$valid, 'name'=>$name, 'email'=>$email, 'pass'=>$pass, 'passConfirm'=>$passConfirm,
                    'nameErr'=>$nameErr, 'emailErr'=>$emailErr, 'passErr'=>$passErr, 'passConfirmErr'=>$passConfirmErr,
                    'page' => 'register', 'header' => 'Register Pagina');

    $view = new RegisterDoc($data);
    $view->show();
?>