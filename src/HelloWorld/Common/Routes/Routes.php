<?php

namespace HelloWorld\Common\Routes;


use HelloWorld\Contracts\Common\Routes\Routes as RoutesCommonContract;


class Routes implements RoutesCommonContract {
    public function filterUri($uri) {
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
}