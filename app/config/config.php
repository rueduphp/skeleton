<?php
    namespace App;

    use Octo\Registry;
    use Octo\Config as CoreConf;
    use function Octo\path;

    $d = __DIR__;

    CoreConf::set('application.name',       defined('SITE_NAME') ? SITE_NAME : 'Octo');
    CoreConf::set('application.dir',        realpath($d . '/../'));
    CoreConf::set('model.dir',              realpath($d . '/../models'));

    CoreConf::set('octalia.dir',            realpath($d . '/../storage/data'));
    CoreConf::set('dir.cache',              realpath($d . '/../storage/cache'));

    /* MySQL */
    CoreConf::set('mysql.username',         'homestead');
    CoreConf::set('mysql.password',         'homestead');

    /* Mailer */
    CoreConf::set('mailer.driver',          'smtp');
    CoreConf::set('mailer.host',            'mailtrap.io');
    CoreConf::set('mailer.port',            2525);
    CoreConf::set('mailer.username',        '');
    CoreConf::set('mailer.password',        '');
    CoreConf::set('mailer.secure',          'tls');
    CoreConf::set('mailer.timeout',         20);
    CoreConf::set('mailer.persistent',      null);

    CoreConf::set('notification.driver',    'mail');

    path('config',          realpath($d));
    path('app',             realpath($d . '/../'));
    path('tasks',           realpath($d . '/../tasks'));
    path('tests',           realpath($d . '/../tests'));
    path('models',          realpath($d . '/../models'));
    path('views',           realpath($d . '/../views'));
    path('controllers',     realpath($d . '/../controllers'));
    path('translations',    realpath($d . '/../translations'));
    path('storage',         realpath($d . '/../storage'));
    path('public',          realpath($d . '/../../public'));

    path('octalia',         CoreConf::get('octalia.dir', session_save_path()));
    path('cache',           CoreConf::get('dir.cache', session_save_path()));

    Registry::set('cb.404', function () {
        if (!headers_sent()) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            header('Location:' . Registry::get('octo.subdir', '') . '/is404');
        }
    });
