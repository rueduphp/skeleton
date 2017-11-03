<?php
    namespace Octo;

    use App\Bootstrap;

    $dir = __DIR__;

    require_once realpath($dir) . '/../vendor/autoload.php';

    systemBoot($dir);

    Octo::init($dir);

    Octo::apply(new Bootstrap());
//    Octo::apply(instanciator()->singleton(Bootstrap::class));
