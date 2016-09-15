<?php
    namespace App;

    class Bootstrap
    {
        public static function run()
        {
            require_once realpath(__DIR__) . '/lib/helpers.php';

            lib('timer')->start();

            require_once realpath(__DIR__) . '/config/config.php';
            require_once realpath(__DIR__) . '/config/routes.php';

            try {
                lib('router')->run(__NAMESPACE__);
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }
