<?php

require_once('ProductDoc.php');

class WebshopDoc extends ProductDoc {
    protected function showHeader() {
        echo '    <h1>Webshop Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if (isset($this->data['connectionErr'])) {
            echo "<p>".$this->data['connectionErr']."</p>".PHP_EOL;
        } else {
            $this->showProductList($this->data['products']);
        }
    }
}

?>