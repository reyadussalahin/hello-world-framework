<?php

namespace HelloWorld\Statics;


use HelloWorld\Contracts\Statics\Routes as RoutesContract;


class Routes implements RoutesContract {
    private $routesBase;
    private $routes;

    private function filterUri($uri) {
        $uri = trim($uri);
        $len = strlen($uri);
        if($len > 0 && $uri[$len-1] === "/") {
            $uri = substr($uri, 0, $len-1);
            $len--;
        }
        if($len > 0 && $uri[0] === "/") {
            $uri = substr($uri, 1);
        }
        return $uri;
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
                    $uri = $prefix . $this->filterUri($uri);
                    $this->routes[$method][$uri] = $details;
                }
            }
        }
    }

    public function get() {
        return $this->routes;
    }
}