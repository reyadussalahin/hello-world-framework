<?php

namespace HelloWorld\App\Outgoing;


use HelloWorld\Contracts\App\Outgoing\Response;


class Text implements Response {
    private $app;
    private $content;

    public function __construct($app, $content) {
        $this->app = $app;
        $this->content = $content;
    }

    public function send() {
        echo $this->content;
    }
}