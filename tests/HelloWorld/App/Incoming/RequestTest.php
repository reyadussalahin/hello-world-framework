<?php

namespace Tests\HelloWorld\App\Incoming;


use PHPUnit\Framework\TestCase;
use HelloWorld\Contracts\App\Incoming\Request as RequestContract;
use HelloWorld\App\Incoming\Request;
use HelloWorld\App\App;
use HelloWorld\App\Globals;


class RequestTest extends TestCase {
    public function testContract() {
        $request  = new Request(null);
        $this->assertTrue($request instanceof RequestContract);
    }

    public function testMethod() {
        global $_SERVER;
        $_SERVER = [];
        $_SERVER["REQUEST_METHOD"] = "POST";

        $request = new Request(
            new App(null, new Globals())
        );

        $this->assertEquals("POST", $request->method());
    }

    public function testUri() {
        global $_SERVER;
        $_SERVER = [];
        $_SERVER["REQUEST_URI"] = "api/users/1234";

        $request = new Request(
            new App(null, new Globals())
        );
        
        $this->assertEquals("api/users/1234", $request->uri());
    }

    public function testHas() {
        global $_REQUEST;
        $_REQUEST = [];
        $_REQUEST["id"] = "1234";

        $request = new Request(
            new App(null, new Globals())
        );
        
        $this->assertTrue($request->has("id"));
    }

    public function testGet() {
        global $_REQUEST;
        $_REQUEST = [];
        $_REQUEST["id"] = "1234";
        
        $request = new Request(
            new App(null, new Globals())
        );
        
        $this->assertEquals("1234", $request->get("id"));
    }
}