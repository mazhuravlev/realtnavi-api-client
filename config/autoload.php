<?php

spl_autoload_register(
    function ($class) {
        require_once ROOT_DIR . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.class.php';
    }
);