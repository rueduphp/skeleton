<?php
    namespace App;

    use Octo\Config as CoreConf;

    CoreConf::set('application.name', 'Octo');
    CoreConf::set('application.dir', realpath(__DIR__ . '/../'));
    CoreConf::set('model.dir', realpath(__DIR__ . '/../models'));

    CoreConf::set('octalia.dir', realpath(__DIR__ . '/../storage/data'));
    CoreConf::set('dir.cache', realpath(__DIR__ . '/../storage/cache'));

    /* MySQL */
    CoreConf::set('mysql.username', 'octo');
    CoreConf::set('mysql.password', 'octo');

    /* Mailer */
    CoreConf::set('mailer.driver', 'smtp');
    CoreConf::set('mailer.host', 'mailtrap.io');
    CoreConf::set('mailer.port', 2525);
    CoreConf::set('mailer.username', '');
    CoreConf::set('mailer.password', '');
    CoreConf::set('mailer.secure', 'tls');
    CoreConf::set('mailer.timeout', 20);
    CoreConf::set('mailer.persistent', null);

    CoreConf::set('notification.driver', 'mail');

    \Octo\path('config',          realpath(__DIR__));
    \Octo\path('app',             realpath(__DIR__ . '/../'));
    \Octo\path('tasks',           realpath(__DIR__ . '/../tasks'));
    \Octo\path('tests',           realpath(__DIR__ . '/../tests'));
    \Octo\path('models',          realpath(__DIR__ . '/../models'));
    \Octo\path('views',           realpath(__DIR__ . '/../views'));
    \Octo\path('controllers',     realpath(__DIR__ . '/../controllers'));
    \Octo\path('translations',    realpath(__DIR__ . '/../translations'));
    \Octo\path('storage',         realpath(__DIR__ . '/../storage'));
    \Octo\path('public',          realpath(__DIR__ . '/../../public'));

    \Octo\path('octalia',         CoreConf::get('octalia.dir', session_save_path()));
    \Octo\path('cache',           CoreConf::get('dir.cache', session_save_path()));

    \Octo\Registry::set('cb.404', function () {
        if (!headers_sent()) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            header('Location:' . \Octo\Registry::get('octo.subdir', '') . '/is404');
        }
    });
