<?php

require_once('ProductDoc.php');

class TopFiveDoc extends ProductDoc {
    protected function showContent() {
        if (isset($this->data['connectionErr'])) {
            echo "<p>".$this->data['connectionErr']."</p>".PHP_EOL;
        } else {
            $this->showProductList($this->data['products']);
        }
    }
}

?>