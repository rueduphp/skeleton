<?php
    namespace App;

    use Octo\ControllerBase;
    use Octo\Registry;

    class AppStaticController extends ControllerBase
    {
        public function boot()
        {

        }

        public function getHome()
        {
            Registry::set('is_home', true);
            $this->title = 'Welcome on Octo Framewaork by Rue du PHP';

            return vue('static.home');
        }

        public function getIs404()
        {
            header("HTTP/1.0 404 Not Found");

            $this->title = "Page not found!";

            return vue('static.404');
        }
    }
