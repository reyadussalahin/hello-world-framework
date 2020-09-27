<?php

namespace HelloWorld\Contracts\App\Incoming;


interface Request {
    public function method();
    public function uri();
    public function has($input);
    public function get($input);
}