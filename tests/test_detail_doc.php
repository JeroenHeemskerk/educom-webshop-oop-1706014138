<?php
    require_once("../views/DetailDoc.php");

    $data = array('product'=>NULL, 'page' => 'detail', 'header' => 'Detail Pagina');
    $data['product'] = array('id'=>1, 'name'=>'Appel', 'price'=>'1.50', 'product_description'=>'apple a day keeps the doctor away', 'img_filename'=>'gala.jpg');

    $view = new DetailDoc($data);
    $view->show();
?>