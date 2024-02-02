<?php

require_once('../Crud.php');
require_once('../ShopCrud.php');
$c = new Crud();
$sc = new ShopCrud($c);
$res = $sc->readProductsById(array(19));

var_dump($res);

$params = array();
foreach ($res as $product) {
    $a = (array) $product;
    $params = array_merge($params, array_values($a));
}
var_dump($params);

echo 'obj ref: '.$res[0]->name;

?>
