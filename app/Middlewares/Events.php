<?php
namespace App\Middlewares;

use App\Events\Dummy;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Octo\FastEvent;
use Octo\FastMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class Events extends FastMiddleware
{
    /**
     * @var FastEvent
     */
    private $manager;

    public function process(ServerRequestInterface $request, DelegateInterface $next)
    {
        $this->manager = $this->getEventManager();

        $this->load();

        return $next->process($request);
    }

    private function load()
    {
        $this->manager->on("dummy0", function () {
            $this->ddbg($this->getEvent());
        });
        $this->manager->on("dummy", Dummy::class);
    }
}
