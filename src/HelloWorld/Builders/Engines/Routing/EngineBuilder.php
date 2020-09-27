<?php

namespace HelloWorld\Builders\Engines\Routing;


use HelloWorld\Contracts\Builders\Builder as BuilderContract;
use HelloWorld\Managers\Routes\Routes;
use HelloWorld\Engines\Routing\Engine as RoutingEngine;


class EngineBuilder implements BuilderContract {
    private $app;
    private $routes;
    private $engine;

    public function __construct($app) {
        $this->app = $app;
    }

    private function getRoutes() {
        if($this->routes === null) {
            $this->routes = (
                new Routes($this->app->base() . "/routes")
            )->get();
        }
        return $this->routes;
    }

    public function get() {
        if($this->engine === null) {
            $this->engine = new RoutingEngine(
                $this->getRoutes()
            );
        }
        return $this->engine;
    }
}