<?php

declare(strict_types=1);

if(!defined("ROOT")) define("ROOT", dirname(__DIR__));

require_once ROOT . "/vendor/autoload.php";

use Core\Middleware\AccessControlMiddleware;
use Core\Middleware\ExceptionHandlerMiddleware;
use Core\Middleware\SessionMiddleware;
use Laminas\Diactoros\{
    Response,
    ServerRequestFactory
};
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use WoohooLabs\Harmony\Middleware\{
    DispatcherMiddleware,
    FastRouteMiddleware,
    LaminasEmitterMiddleware
};

// Initializing config
app()->init(ROOT . '/config');

// Initializing the router
$router = FastRoute\simpleDispatcher(static function (FastRoute\RouteCollector $r) {
    $base_path = app()->config('application.base_path', '');
    $routes = app()->config('route', []);

    foreach($routes as $name => $params){
        list($method, $path, $handler) = $params;
        $r->addRoute($method, $base_path . $path, $handler);
    }
});

// Instantiating the framework
$app = app()->make(ServerRequestFactory::fromGlobals(), new Response());

// Stacking up middleware
$app
    ->addMiddleware(new LaminasEmitterMiddleware(new SapiEmitter()))
    ->addMiddleware(new ExceptionHandlerMiddleware())
    ->addMiddleware(new SessionMiddleware())
    ->addMiddleware(new AccessControlMiddleware())
    ->addMiddleware(new FastRouteMiddleware($router))
    ->addMiddleware(new DispatcherMiddleware())
    ->run();