<?php

namespace App\Events;

use Octo\Framework;
use Octo\Listener;
use Octo\Orm;

class Dummy
{
    use Framework;

    public function __invoke(Orm $orm)
    {
        $this->ddbg($this->getEvent());
        die('ddd');
    }
}