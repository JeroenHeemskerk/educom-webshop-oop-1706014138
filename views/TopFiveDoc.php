<?php

require_once('ProductDoc.php');

class TopFiveDoc extends ProductDoc {
    protected function showHeader() {
        echo '    <h1>Top 5 Appels van de Week</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if (!empty($this->model->connectionErr)) {
            echo "<p>".$this->model->connectionErr."</p>".PHP_EOL;
        } else {
            $this->showProductList($this->model->products, 'topfive');
        }
    }
}

?>