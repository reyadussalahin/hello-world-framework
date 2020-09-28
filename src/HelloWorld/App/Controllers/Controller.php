<?php

namespace HelloWorld\App\Controllers;


use HelloWorld\Contracts\App\Controllers\Controller as ControllerContract;


class Controller implements ControllerContract {
    protected $app;

    public function __construct($app) {
        $this->app = $app;
    }
}