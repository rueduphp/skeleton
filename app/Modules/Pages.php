<?php
namespace App\Modules;

use Octo\FastRendererInterface;
use Octo\FastRouterInterface;
use Octo\FastTwigRenderer;
use Octo\Fast;
use Octo\Module;

class Pages extends Module
{
    /**
     * @var FastTwigRenderer
     */
    private $renderer;

    /**
     * @var Fast
     */
    private $app;

    /**
     * @param Fast $app
     */
    public function config(Fast $app)
    {
        $this->app = $app;
        $app->twigRenderer(__DIR__ . DS . 'views'. DS . 'Pages');
    }

    /**
     * @param Fast $app
     * @param FastTwigRenderer $renderer
     */
    public function di(Fast $app, FastRendererInterface $renderer)
    {
        $this->app = $app;
        $this->renderer = $renderer;
    }

    /**
     * @param FastRouterInterface $router
     */
    public function routes(FastRouterInterface $router)
    {
        $router
            ->addRoute('GET', '/home', [$this, 'home'], 'home2')
            ->addRoute('GET', '/', [$this, 'home'])
        ;
    }

    public function home()
    {
        return $this->renderer->render('home');
    }

}