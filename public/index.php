<?php
    namespace Octo;

    use App\Bootstrap;

    $dir = __DIR__;

    require_once realpath($dir) . '/../vendor/autoload.php';

    try {
        systemBoot($dir);

        Octo::init($dir);

        Octo::apply(new Bootstrap());
    } catch (\Exception $e) {
        dd($e);
    }
