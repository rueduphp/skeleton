<?php
    namespace App;

    use Octo\Route      as Routing;
    use UserEntity      as User;

    Routing::get('/', "static@home")->as('home');
    Routing::any('is404', "static@is404")->as(404);
