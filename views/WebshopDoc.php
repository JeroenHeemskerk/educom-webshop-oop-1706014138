<?php

require_once('ProductDoc.php');

class WebshopDoc extends ProductDoc {
    protected function showHeader() {
        echo '    <h1>Webshop Pagina</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if (!empty($this->model->connectionErr)) {
            echo "<p>".$this->model->connectionErr."</p>".PHP_EOL;
        } else {
            $this->showProductList($this->model->products, 'webshop');
        }
    }
}

?>