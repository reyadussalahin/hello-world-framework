<?php

namespace HelloWorld\Contracts\Engines\Routing;


interface Engine {
    public function resolve($method, $uri);
}