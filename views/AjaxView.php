<?php

class AjaxView {
    private $result;

    public function __construct($result) {
        $this->result = $result;
    }

    public function show() {
        $this->sendJSON();
    }

    public function sendJSON() {
        echo json_encode($this->result);
    }
}

?>
