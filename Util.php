<?php

class Util {
    public static function getPostVar($key, $default='') {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    public static function getUrlVar($key, $default='') {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
}

?>
