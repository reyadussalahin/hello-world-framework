<?php

namespace HelloWorld\Managers\Routes;


use HelloWorld\Contracts\Managers\Routes\RoutesManager as RoutesManagerContract;
use HelloWorld\Commons\Routes\RoutesCommon;


class RoutesManager implements RoutesManagerContract {
    private $app;
    private $routesBase;
    private $routesCommon;
    private $routes;

    public function __construct($app) {
        $this->app = $app;
    }

    private function getRoutesBase() {
        if($this->routesBase === null) {
            $this->routesBase = $this->app->base() . "/routes";
        }
        return $this->routesBase;
    }

    private function getRoutesCommon() {
        if($this->routesCommon === null) {
            $this->routesCommon = new RoutesCommon();
        }
        return $this->routesCommon;
    }

    private function getRoutes() {
        if($this->routes === null) {
            $this->routes = [];
            $all = require $this->getRoutesBase() . "/routes.php";
            foreach($all as $type => $info) {
                $routesOfType = require $this->getRoutesBase() . "/" . $info["path"];
                $prefix = "";
                if($type !== "http") {
                    $prefix = $info["prefix"];
                    if($prefix[strlen($prefix) - 1] !== "/") {
                        $prefix .= "/";
                    }
                }
                foreach($routesOfType as $method => $list) {
                    if(!isset($this->routes[$method])) {
                        $this->routes[$method] = [];
                    }
                    foreach($list as $uri => $details) {
                        $uri = $prefix . $this->getRoutesCommon()->filterUri($uri);
                        $this->routes[$method][$uri] = $details;
                    }
                }
            }
        }
        return $this->routes;
    }

    public function get() {
        return $this->getRoutes();
    }
}