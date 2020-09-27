<?php

namespace HelloWorld\Contracts\Engines\Routing;


interface RoutingEngine {
    public function resolve($method, $uri);
}