<?php

namespace HelloWorld\App\Incoming;


use HelloWorld\Contracts\App\Incoming\Request as RequestContract;


class Request implements RequestContract {
    private $app;
    private $globals;

    public function __construct($app) {
        $this->app = $app;
    }

    private function globals() {
        if($this->globals === null) {
            $this->globals = $this->app->globals();
        }
        return $this->globals;
    }

    public function method() {
        return $this->globals()->server()["REQUEST_METHOD"];
    }

    public function uri() {
        return $this->globals()->server()["REQUEST_URI"];
    }

    public function has($input) {
        return isset($this->globals()->request()[$input]);
    }

    public function get($input) {
        return $this->globals()->request()[$input];
    }
}