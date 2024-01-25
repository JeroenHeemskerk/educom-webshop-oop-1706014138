<?php

require_once('HtmlDoc.php');

class BasicDoc extends HtmlDoc {
    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }

    protected function showHeader() {

    }

    private function showMenu() {
        echo '    <ul class="menu">' . PHP_EOL;
        foreach($this->model->menu as $key=>$value) {
            $this->showMenuItem($key, $value);
        }
        echo '    </ul>' . PHP_EOL;
    }

    private function showMenuItem($link, $label) {
        echo '        <li><a href="index.php?page=' . $link . '">' . $label . '</a></li>' . PHP_EOL;
    }

    protected function showContent() {

    }

    private function showFooter() {
        echo '    <footer>' . PHP_EOL;
        echo '        <p>&copy 2024, Thomas van Haastrecht</p>' . PHP_EOL;
        echo '    </footer>' . PHP_EOL;
    }

    protected function showBodyContent() {
        $this->showHeader();
        $this->showMenu();
        $this->showContent();
        $this->showFooter();
    }
}

?>