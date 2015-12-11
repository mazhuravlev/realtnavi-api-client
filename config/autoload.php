<?php

spl_autoload_register(
    function ($class) {
        require_once ROOT_DIR . $class . '.class.php';
    }
);