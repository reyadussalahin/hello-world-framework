<?php

namespace HelloWorld\Builders\Engines\Routing;


use HelloWorld\Contracts\Builders\Builder as BuilderContract;
use HelloWorld\Managers\Routes\Routes as RoutesManager;
use HelloWorld\Engines\Routing\Engine as RoutingEngine;


class Builder implements BuilderContract {
    private $app;
    private $routes;
    private $engine;

    public function __construct($app) {
        $this->app = $app;
    }
    
    private function getRoutes() {
        if($this->routes === null) {
            $routesManager = new RoutesManager(
                $this->app->base() . "/routes"
            );
            $this->routes = $routesManager->get();
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