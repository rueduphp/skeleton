<?php
namespace App;

use Geocoder\Geocoder;
use Octo\Cache;
use Octo\Caching;
use Octo\Fast;
use Octo\FastCacheInterface;
use Octo\Fastcontainer;
use Octo\Fastmiddlewarecsrf;
use Octo\Fastmiddlewaredispatch;
use Octo\Fastmiddlewaregeo;
use Octo\Fastmiddlewarenotfound;
use Octo\Fastmiddlewarerouter;
use Octo\Fastmiddlewaretrailingslash;
use Octo\FastRendererInterface;
use Octo\FastRouterInterface;
use Octo\FastSessionInterface;
use Octo\Framework;
use Octo\Live;
use Octo\Orm;
use Octo\Session;
use PDO;
use function Octo\sessionKey;

class Bootstrap
{
    use Framework;

    /**
     * @var Fast
     */
    private $app;

    /**
     * @var Session
     */
    private $session;

    /**
     * @param Fast $app
     *
     * @throws \Octo\Exception
     * @throws \TypeError
     */
    public function __invoke(Fast $app)
    {
        $this->app = $app;
        $this->session = new Live(new Caching(sessionKey()));

        $response = $this
            ->config()
            ->register()
            ->middlewares()
            ->modules()
            ->getApp()
            ->run($this->app->fromGlobals())
        ;

        $this->app->render($response);
    }

    public function cli(Fast $app)
    {
        $this->app = $app;

        $this
            ->config()
            ->register()
        ;
    }

    /**
     * @return Fast
     */
    public function getApp(): Fast
    {
        return $this->app;
    }

    /**
     * @return $this
     */
    private function config()
    {
        return $this;
    }

    /**
     * @return $this
     */
    private function register()
    {
        $this->app
            ->set(Orm::class, function () {
                $pdo = $this->get('pdo');

                if (!$pdo instanceof PDO) {
                    $host       = getenv('MYSQL_HOST');
                    $port       = getenv('MYSQL_PORT');
                    $database   = getenv('MYSQL_DATABASE');
                    $password   = getenv('MYSQL_ROOT_PASSWORD');

                    $options = [
                        PDO::ATTR_CASE                 => PDO::CASE_NATURAL,
                        PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_ORACLE_NULLS         => PDO::NULL_NATURAL,
                        PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC,
                        PDO::ATTR_STRINGIFY_FETCHES    => false,
                        PDO::ATTR_EMULATE_PREPARES     => false
                    ];

                    $pdo = new PDO(
                        "mysql:host={$host};port={$port};dbname=" .
                        $database,
                        'root',
                        $password,
                        $options
                    );

                    $this->set('pdo', $pdo);
                }

                return new Orm($pdo);
            })
            ->set(Fastcontainer::class, function () {
                return $this->instanciator()->singleton(Fastcontainer::class);
            })
            ->set(Fastmiddlewarecsrf::class, function () {
                return new Fastmiddlewarecsrf($this->session);
            })
            ->set(Geocoder::class, function () {
                return Fastmiddlewaregeo::createGeocoder();
            })
            ->set(FastSessionInterface::class, function () {
                return new Live(new Caching(sessionKey()));
            })
            ->set(FastCacheInterface::class, function () {
                return new Cache;
            })
            ->set(FastRouterInterface::class, function () {
                return $this->app->router();
            })
            ->set(FastRendererInterface::class, function () {
                return $this->app->getRenderer();
            })
        ;

        return $this;
    }

    /**
     * @return $this
     */
    private function middlewares()
    {
        $this->app
            ->addMiddleware(Middlewares\Events::class)
            ->addMiddleware(Fastmiddlewaretrailingslash::class)
            ->addMiddleware(Fastmiddlewarecsrf::class)
//            ->addMiddleware(Fastmiddlewaregeo::class)
//            ->addMiddleware(Fastmiddlewareacl::class)
//            ->addMiddleware(Fastmiddlewaremustbeauthorized::class)
            ->addMiddleware(Fastmiddlewarerouter::class)
            ->addMiddleware(Fastmiddlewaredispatch::class)
            ->addMiddleware(Fastmiddlewarenotfound::class)
        ;

        return $this;
    }

    /**
     * @return $this
     */
    private function modules()
    {
        $this->app
            ->addModule(Modules\Pages::class)
        ;

        return $this;
    }

    /**
     * @param FastSessionInterface $session
     *
     * @return Bootstrap
     */
    public function setSession(FastSessionInterface $session): Bootstrap
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return FastSessionInterface
     */
    public function getSession(): FastSessionInterface
    {
        return $this->session;
    }
}
