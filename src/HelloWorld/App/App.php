<?php

namespace HelloWorld\App;


use HelloWorld\Contracts\App\App as AppContract;
use HelloWorld\Http\Outgoing\Text;


class App implements AppContract {
    private $base;
    private $globals;

    public function __construct($base, $globals) {
        $this->base = $base;
        $this->globals = $globals;
    }

    public function base() {
        return $this->base;
    }

    public function process() {
        return new Text(
            "Hello, World!"
        );
    }
}