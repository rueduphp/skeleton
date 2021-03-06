<?php
    namespace Octo;

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', true);

    $ini = parse_ini_file(__DIR__ . '/.env');

    defined('APPLICATION_ENV') || define('APPLICATION_ENV', isset($ini['APPLICATION_ENV']) ? $ini['APPLICATION_ENV'] : 'production');
    defined('SITE_NAME') || define('SITE_NAME', isset($ini['SITE_NAME']) ? $ini['SITE_NAME']         : 'project');

    require_once realpath(__DIR__) . '/vendor/autoload.php';

    path("app", realpath(__DIR__ . '/app'));
    path("base", realpath(__DIR__));

    systemBoot(__DIR__);

    Octo::cli();
