<?php

namespace HelloWorld\App\Outgoing;


use HelloWorld\Contracts\App\Outgoing\Response;


class Text implements Response {
    private $content;

    public function __construct($content) {
        $this->content = $content;
    }

    public function send() {
        echo $this->content;
    }
}