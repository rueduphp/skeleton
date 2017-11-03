<?php
    $host       = getenv('MYSQL_HOST');
    $port       = getenv('MYSQL_PORT');
    $database   = getenv('MYSQL_DATABASE');
    $password   = getenv('MYSQL_ROOT_PASSWORD');

    $options = [
        PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION
    ];

    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=" .
        $database,
        'root',
        $password,
        $options
    );

    return [
        'paths' => [
            'migrations' => __DIR__ . '/app/databases/migrations',
            'seeds'      => __DIR__ . '/app/databases/seeds'
        ],
        'environments' => [
            'default_database' => 'orm',
            'orm'      => [
                'name'       => 'orm',
                'connection' => $pdo
            ]
        ]
    ];
