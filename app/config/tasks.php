<?php
    Octo\Autoloader::map(App\Tasks\Dummy::class, realpath(__DIR__ . '/../tasks/Dummy.php'));

    return [
        'dummy' => App\Tasks\Dummy::class
    ];
