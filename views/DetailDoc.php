<?php

require_once('ProductDoc.php');

class DetailDoc extends ProductDoc {
    protected function showHeader() {
        echo '    <h1>Detail Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if (!empty($this->model->connectionErr)) {
            echo "<p>".$this->model->connectionErr."</p>".PHP_EOL;
        } else {
            $product = $this->model->products[0];

            echo "<h3>".$product['name']."</h3>" . PHP_EOL;
            echo "<h4>Price: $".$product['price']."</h4>" . PHP_EOL;
            $this->showAddToCartForm('detail', $product['id']);
            echo "<p>".$product['product_description']."</p>" . PHP_EOL;
            echo "<img class='detail_img' alt='Image of ".$product['name']."' src='Images/".$product['img_filename']."'>" . PHP_EOL;
        }
    }
}

?>