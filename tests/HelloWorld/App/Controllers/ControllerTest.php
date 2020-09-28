<?php

namespace Tests\HelloWorld\App\Controllers;


use PHPUnit\Framework\TestCase;
use HelloWorld\Contracts\App\Controllers\Controller as ControllerContract;
use HelloWorld\App\Controllers\Controller;


class ControllerTest extends TestCase {
    public function testContract() {
        $controller = new Controller(null);
        $this->assertTrue($controller instanceof ControllerContract);
    }
}