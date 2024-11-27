<?php

namespace App;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $relativeClass = str_replace(__NAMESPACE__ . '\\', '', $class);
            $file = __DIR__ . '/' . str_replace('\\', '/', $relativeClass) . '.php';
            require_once $file;


        });
    }
}
