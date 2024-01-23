<?php
    
    function topFiveHeader() {
        $header = 'Top 5 Appels van de Week';
        return $header;
    }

    function showTopFiveContent($data) {
        if (isset($data['connectionErr'])) {
            echo "<p>".$data['connectionErr']."</p>".PHP_EOL;
        } else {
            showProductList($data['products']);
        }
    }
?>