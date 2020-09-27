<?php

namespace HelloWorld\Managers\Routes;


use HelloWorld\Contracts\Managers\Routes\Routes as RoutesContract;
use HelloWorld\Commons\Routes\Routes as RoutesCommon;


class Routes implements RoutesContract {
    private $routesBase;
    private $routes;
    private $routesCommon;

    private function routesCommon() {
        if($this->routesCommon === null) {
            $this->routesCommon = new RoutesCommon();
        }
        return $this->routesCommon;
    }

    public function __construct($routesBase) {
        $this->routesBase = $routesBase;
        $this->routes = [];

        $all = require $routesBase . "/routes.php";
        foreach($all as $type => $info) {
            $routesOfType = require $routesBase . "/" . $info["path"];
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
                    $uri = $prefix . $this->routesCommon()->filterUri($uri);
                    $this->routes[$method][$uri] = $details;
                }
            }
        }
    }

    public function get() {
        return $this->routes;
    }
}