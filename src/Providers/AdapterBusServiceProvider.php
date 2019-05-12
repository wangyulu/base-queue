<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-08
 * Time: 14:01
 */

namespace Sky\BaseQueue\Providers;

use Log;
use Sky\BaseQueue\Librarys\EventMap;
use Illuminate\Support\Facades\Route;
use Illuminate\Bus\BusServiceProvider;
use Sky\BaseQueue\Events\QueueEndEvent;
use Sky\BaseQueue\Events\QueueFailEvent;
use Sky\BaseQueue\Events\QueueStartEvent;
use Illuminate\Contracts\Events\Dispatcher;
use Sky\BaseQueue\Librarys\AdapterDispatcher;
use Illuminate\Contracts\Bus\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Contracts\Bus\QueueingDispatcher as QueueingDispatcherContract;

class AdapterBusServiceProvider extends BusServiceProvider
{
    use EventMap;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->overload();
        $this->registerEvents();
        $this->registerListener();
        $this->registerRoutes();
    }

    public function overload()
    {
        $this->app->singleton(AdapterDispatcher::class, function ($app) {
            return new AdapterDispatcher($app, function ($connection = null) use ($app) {
                return $app[QueueFactoryContract::class]->connection($connection);
            });
        });
        $this->app->alias(
            AdapterDispatcher::class, DispatcherContract::class
        );
        $this->app->alias(
            AdapterDispatcher::class, QueueingDispatcherContract::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            AdapterDispatcher::class,
            DispatcherContract::class,
            QueueingDispatcherContract::class,
        ];
    }

    /**
     * Setup the configuration for Horizon.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/que.php', 'que'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/database.php', 'database.connections'
        );
    }

    /**
     * Register the Horizon job events.
     *
     * @return void
     */
    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    public function registerListener()
    {
        $this->app['queue']->before(function ($event) {
            event(new QueueStartEvent($event));
        });

        $this->app['queue']->after(function ($event) {
            event(new QueueEndEvent($event));
        });

        $this->app['queue']->exceptionOccurred(function ($event) {
            event(new QueueFailEvent($event));
        });

        $this->app['queue']->failing(function ($event) {
            event(new QueueFailEvent($event));
        });
    }

    /**
     * Register the Horizon routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'prefix'    => config('que.path'),
            'namespace' => 'Sky\BaseQueue\Http\Controllers',
        ], function () {
            require __DIR__ . '/../../routes/web.php';
        });
    }
}