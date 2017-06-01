<?php
    namespace Octo;

    return ['mysql' => [
        'host'      => appenv('DATABASE_HOST'),
        'port'      => appenv('DATABASE_PORT'),
        'database'  => appenv('DATABASE_NAME'),
        'user'      => appenv('DATABASE_USER'),
        'password'  => appenv('DATABASE_PASSWORD'),
    ]];
