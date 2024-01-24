<?php

require_once('BasicDoc.php');

class HomeDoc extends BasicDoc {
    protected function showContent() {
        echo '    <p>Welkom! Deze simpele HTML pagina is vrij simpel. Vandaar de naam.</p>';
    }
}

?>