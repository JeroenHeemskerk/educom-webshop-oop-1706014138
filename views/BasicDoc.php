<?php

require_once('HtmlDoc.php');

class BasicDoc extends HtmlDoc {
    protected $data;

    public function __construct($d) {
        $this->data = $d;
    }

    private function showHeader() {
        echo '    <h1>' . $this->data['header'] . '</h1>' . PHP_EOL;

    }

    private function showMenu() {
        echo '    <ul class="menu">' . PHP_EOL;
        $this->showMenuItem('home', 'HOME');
        $this->showMenuItem('about', 'ABOUT');
        $this->showMenuItem('contact', 'CONTACT');
        $this->showMenuItem('webshop', 'WEBSHOP');
        $this->showMenuItem('topfive', 'TOP 5');
        require_once('../session_manager.php');
        if (isUserLoggedIn()) {
            $this->showMenuItem('cart', 'SHOPPING CART');
            $this->showMenuItem('logout', 'LOGOUT ' . getLoggedInUsername());
        } else {
            $this->showMenuItem('register', 'REGISTER');
            $this->showMenuItem('login', 'LOGIN');
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