<?php
    namespace App\Controllers;

    use Octo\ControllerBase;
    use Octo\Registry;
    use Octo\Octo;

    use function Octo\vue;

    class StaticController extends ControllerBase
    {
        public function boot()
        {

        }

        public function getHome()
        {
            Registry::set('is_home', true);
            $this->title = 'Accueil';

            return vue('static.home');
        }

        public function getIs404()
        {
            header("HTTP/1.0 404 Not Found");

            $this->title = "Page introuvable";

            return vue('static.404');
        }
    }
