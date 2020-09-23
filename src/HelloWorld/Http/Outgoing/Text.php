<?php

namespace HelloWorld\Http\Outgoing;


use HelloWorld\Contracts\Http\Outgoing\Response;


class Text implements Response {
    private $content;

    public function __construct($content) {
        $this->content = $content;
    }

    public function send() {
        echo $this->content;
    }
}