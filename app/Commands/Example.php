<?php
namespace App\Commands;

use Octo\Cli;
use Octo\Fast;

class Example
{
    /**
     * @param Fast $app
     */
    public function test_cmd(Fast $app)
    {
        Cli::show(__FUNCTION__);
    }
}