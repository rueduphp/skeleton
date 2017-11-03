<?php
namespace App;

use Octo\FastTrait;

class Bootstrap
{
    use FastTrait;

    public function __invoke($app)
    {
        $this->ldd($app);
    }
}