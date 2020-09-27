<?php

namespace Tests\HelloWorld\App;


use PHPUnit\Framework\TestCase;
use HelloWorld\App\App;
use HelloWorld\Contracts\App\App as AppContract;
use HelloWorld\App\Globals;
use HelloWorld\App\Incoming\Request;
use HelloWorld\App\Outgoing\Text;
use HelloWorld\Contracts\App\Outgoing\Response;


class AppTest extends TestCase {
    public function testContract() {
        $app = new App(null, null);
        $this->assertEquals(true, $app instanceof AppContract);
    }
    
    public function testBase() {
        $app = new App("base", null);
        $this->assertEquals("base", $app->base());
    }

    public function testGlobals() {
        $app = new App(null, new Globals());
        $this->assertTrue($app->globals() instanceof Globals);
    }

    public function testRequest() {
        $app = new App(null, null);
        $this->assertTrue($app->request() instanceof Request);
    }

    public function testText() {
        $app = new App(null, null);
        $this->assertTrue($app->text("") instanceof Text);
    }
    
    public function testProcess() {
        $app = new App("base", null);
        $response = $app->process();
        $this->assertEquals(true, $response instanceof Response);
    }
}