<?php

namespace HelloWorld\Commons\Routes;


use HelloWorld\Contracts\Commons\Routes\RoutesCommon as RoutesCommonContract;


class RoutesCommon implements RoutesCommonContract {
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