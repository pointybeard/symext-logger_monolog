<?php

declare(strict_types=1);

if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    throw new Exception(sprintf(
        'Could not find composer autoload file %s. Did you run `composer update` in %s?',
        __DIR__.'/vendor/autoload.php',
        __DIR__
    ));
}

require_once __DIR__.'/vendor/autoload.php';

use pointybeard\Symphony\Extended;

// This file is included automatically in the composer autoloader, however,
// Symphony might try to include it again which would cause a fatal error.
// Check if the class already exists before declaring it again.
if (!class_exists('\\Extension_Logger_Monolog')) {
    class Extension_Logger_Monolog extends Extended\AbstractExtension
    {
        public static function providerOf($type = null)
        {
            return [
                'logger_classpath' => [[
                    'class' => '\\pointybeard\\Symphony\\Extensions\\Logger_Monolog\\Monolog',
                    'name' => 'Monolog',
                ]],
            ];
        }
    }
}
