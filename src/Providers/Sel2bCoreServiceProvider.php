<?php

namespace Sel2b\Core\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\Redirector;
use Laravel\Lumen\Http\ResponseFactory;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Sel2b\Core\Libraries\Constant;
use Sel2b\Core\Services\BCMath\BCMathFacade;

class Sel2bCoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Register language
        $langFolder = __DIR__ . '/../resources/lang';
        Lang::addNamespace(Constant::NAMESPACE, $langFolder);

        //Register view
        $viewDirPackage = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($viewDirPackage, Constant::NAMESPACE);

        $this->publishes([
            $viewDirPackage => base_path('resources/views/vendor/Sel2b/Core'),
            $langFolder     => base_path('resources/lang/vendor/Sel2b/Core'),
        ]);

        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/../routes/routes.php';
        }

        //Log
        $maxFiles = Constant::MAX_FILE_LOG;
        $handlers[] = (new RotatingFileHandler(storage_path("logs/sel2b.log"), $maxFiles))
            ->setFormatter(new LineFormatter(null, null, true, true));

        $this->app['log']->setHandlers($handlers);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        BCMathFacade::init();

        $this->app->bind(Constant::IOC_RESTFUL, function () {
            return $this->getBindingGuzzle();
        });

        $this->app->bind(Constant::IOC_RESTFUL_REQUEST, function ($app, $params) {
            return $this->getBindingGuzzleRequest($params[0], $params[1]);
        });

        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
            return new ResponseFactory(
                $app['Illuminate\Contracts\View\Factory'],
                $app[Redirector::class]
            );
        });

        $this->app->bind(\Illuminate\Contracts\Routing\UrlGenerator::class, function ($app) {
            return new \Laravel\Lumen\Routing\UrlGenerator($app);
        });
    }

    /**
     * @return Client
     */
    private function getBindingGuzzle()
    {
        $client = new Client([
            RequestOptions::HTTP_ERRORS => false
        ]);
        return $client;
    }

    /**
     * @param string $method
     * @param string $url
     * @return \GuzzleHttp\Psr7\Request
     */
    private function getBindingGuzzleRequest($method, $url)
    {
        $request = new \GuzzleHttp\Psr7\Request($method, $url);
        return $request;
    }
}
