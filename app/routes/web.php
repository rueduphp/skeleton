<?php
    namespace App;

    use Octo\Route  as Routing;
    use UserEntity  as User;

    Routing::get('/', [Controllers\StaticController::class, 'home'])->as('home');
    Routing::any('is404', [Controllers\StaticController::class, 'is404'])->as(404);
