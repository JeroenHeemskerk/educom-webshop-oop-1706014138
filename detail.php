<?php
    
    function detailHeader() {
        $header = 'Detail Pagina';
        return $header;
    }

    function showDetailContent($data) {
        if ($data['connectionErr']) {
            echo "<p>".$data['connectionErr']."</p>".PHP_EOL;
        } else {
            require_once('user_service.php');
            $product = $data['product'];

            echo "<h3>".$product['name']."</h3>" . PHP_EOL;
            echo "<h4>Price: $".$product['price']."</h4>" . PHP_EOL;
            showAddToCartForm('detail', $product['id']);
            echo "<p>".$product['product_description']."</p>" . PHP_EOL;
            echo "<img class='detail_img' alt='Image of ".$product['name']."' src='Images/".$product['img_filename']."'>" . PHP_EOL;
        }
    }

?>
