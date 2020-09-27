<?php

namespace HelloWorld\Builders\Engines\Routing;


use HelloWorld\Contracts\Builders\Builder as BuilderContract;
use HelloWorld\Managers\Routes\RoutesManager;
use HelloWorld\Engines\Routing\RoutingEngine;


class RoutingEngineBuilder implements BuilderContract {
    private $app;
    private $routes;
    private $engine;

    public function __construct($app) {
        $this->app = $app;
    }
    
    private function getRoutes() {
        if($this->routes === null) {
            $routesManager = new RoutesManager(
                $this->app
            );
            $this->routes = $routesManager->get();
        }
        return $this->routes;
    }

    private function getEngine() {
        if($this->engine === null) {
            $this->engine = new RoutingEngine(
                $this->getRoutes()
            );
        }
        return $this->engine;
    }

    public function get() {
        return $this->getEngine();
    }
}