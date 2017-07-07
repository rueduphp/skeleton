<?php
    namespace Octo;

    $dir = __DIR__;
    $ini = parse_ini_file($dir . '/../.env');

    defined('APPLICATION_ENV') || define('APPLICATION_ENV', isset($ini['APPLICATION_ENV']) ? $ini['APPLICATION_ENV'] : 'production');
    defined('SITE_NAME') || define('SITE_NAME', isset($ini['SITE_NAME']) ? $ini['SITE_NAME']         : 'project');

    require_once realpath($dir) . '/../vendor/autoload.php';

    $root = realpath($dir . '/../');

    $nameDir = Arrays::last(explode(DS, $root));

    if (fnmatch('/' . $nameDir . '/*', $_SERVER['REQUEST_URI'])) {
        define('FROM_ROOT', $nameDir);
    }

    path("base",       $root);
    path("app",        realpath($root . '/app'));
    path('public',     realpath($dir));

    try {
        systemBoot($dir);

        $errors = [];

        if (!is_writable($dir . '/../app/models')) {
            $errors[] = $dir  . '/../app/models';
        }

        if (!is_writable($dir  . '/../app/storage/data')) {
            $errors[] = $dir  . '/../app/storage/data';
        }

        if (!is_writable($dir  . '/../app/storage/cache')) {
            $errors[] = $dir  . '/../app/storage/cache';
        }

        if (!is_writable($dir  . '/../app/storage/tmp')) {
            $errors[] = $dir  . '/../app/storage/tmp';
        }

        if (!empty($errors)) {
            $html = "<h1><i class='fa fa-warning fa-2x'></i> Some errors occured</h1>";
            $html .= "<h3>Please chmod 0777 these directories :</h3>";
            $html .= "<ul>";

            foreach ($errors as $error) {
                $html .= "<li>" . realpath($error) . "</li>";
            }

            $html .= "</ul>";
            view($html, 500, 'Octo Error Report');
        }

        Octo::run();
    } catch (Exception $e) {
        $debug = Config::get("debug", true);

        if (true === $debug) {
            ob_start();
            echo '<h1><i class="fa fa-info-circle fa-2x"></i> Infos</h1>';
            $infos = Registry::get('BACKTRACE', $e->getTrace());
            echo '<pre>';
            var_dump($infos);
            echo '</pre>';

            $trace = ob_get_clean();

            $html = '<h1><i class="fa fa-warning fa-2x"></i> Error to boot Octo</h1>';
            $html .= 'Please read the next message to fix.';
            $html .= '<div style="margin-top: 15px;" class="alert alert-danger">
            ' . $e->getMessage();

            if (!Registry::has('BACKTRACE')) {
                $html .= '<hr>in ' . $e->getFile() . ' (line: ' . $e->getLine() . ')';
            }

            $html .= '</div><hr>' . $trace . '';

            view($html, 500, 'Octo Error Report');
        }
    }
