<?php

require_once('Crud.php');
require_once('ShopCrud.php');
$c = new Crud();
$sc = new ShopCrud($c);
$res = $sc->readProductsById(array(1,2,4));

$params = array();
foreach ($res as $product) {
    $a = (array) $product;
    $params = array_merge($params, array_values($a));
}
var_dump($params);

echo 'obj ref: '.$res[0]->name;

?>
