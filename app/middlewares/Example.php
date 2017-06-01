<?php
    namespace App\middlewares;

    use function Octo\session;
    use function Octo\objectify;

    class Example
    {
        public function applyBefore($request, $app)
        {
            if ($user = session('web')->getUser()) {
                objectify('user', $user);
            }
        }

        public function applyAfter($request, $app)
        {
        }
    }
