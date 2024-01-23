<?php
    
    function webshopHeader() {
        $header = 'Appel Store';
        return $header;
    }

    function showWebshopContent($data) {
        if (isset($data['connectionErr'])) {
            echo "<p>".$data['connectionErr']."</p>".PHP_EOL;
        } else {
            showProductList($data['products']);
        }
    }
?>
