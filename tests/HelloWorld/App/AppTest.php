<?php

use PHPUnit\Framework\TestCase;
use HelloWorld\App\App;
use HelloWorld\Contracts\App\App as AppContract;
use HelloWorld\Contracts\Http\Outgoing\Response;


class AppTest extends TestCase {
    public function testContract() {
        $app = new App(null, null);
        $this->assertEquals(true, $app instanceof AppContract);
    }
    public function testBase() {
        $app = new App("base", null);
        $this->assertEquals("base", $app->base());
    }
    public function testProcess() {
        $app = new App("base", null);
        $response = $app->process();
        $this->assertEquals(true, $response instanceof Response);
    }
}