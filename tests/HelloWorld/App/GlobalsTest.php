<?php

namespace Tests\HelloWorld\App;


use PHPUnit\Framework\TestCase;
use HelloWorld\Contracts\App\Globals as GlobalsContract;
use HelloWorld\App\Globals;


// all these have been commented, cause this type of declaration
// creates problems with phpunit
// so, I've tested all globals using `global $GLOBALS` type of declaration
// inside function
// which is actually a better awesome for testing
// for details see test functions

// declaring all globals on which \HelloWorld\App\Globals is dependent
// for test purposes
// $GLOBALS = "globals";
// $_SERVER = "server";
// $_GET = "get";
// $_POST = "post";
// $_FILES = "files";
// $_COOKIE = "cookie";
// $_SESSION = "session";
// $_REQUEST = "request";
// $_ENV = "env";


class GlobalTest extends TestCase {
    public function testContract() {
        $globals = new Globals();
        $this->assertEquals(true, $globals instanceof GlobalsContract);
    }
    public function testAll() {
        $globals = new Globals();
        $this->assertEquals(true, is_array($globals->all()));
    }
    public function testGlobals() {
        global $GLOBALS;
        $GLOBALS = "globals";
        $globals = new Globals();
        $this->assertEquals("globals", $globals->globals());
        $GLOBALS = "changed";
        $this->assertEquals("changed", $globals->globals());
    }
    public function testServer() {
        global $_SERVER;
        $_SERVER = "server";
        $globals = new Globals();
        $this->assertEquals("server", $globals->server());
        $_SERVER = "changed";
        $this->assertEquals("changed", $globals->server());
    }
    public function testGet() {
        global $_GET;
        $_GET = "get";
        $globals = new Globals();
        $this->assertEquals("get", $globals->get());
        $_GET = "changed";
        $this->assertEquals("changed", $globals->get());
    }
    public function testPost() {
        global $_POST;
        $_POST = "post";
        $globals = new Globals();
        $this->assertEquals("post", $globals->post());
        $_POST = "changed";
        $this->assertEquals("changed", $globals->post());
    }
    public function testFiles() {
        global $_FILES;
        $_FILES = "files";
        $globals = new Globals();
        $this->assertEquals("files", $globals->files());
        $_FILES = "changed";
        $this->assertEquals("changed", $globals->files());
    }
    public function testCookie() {
        global $_COOKIE;
        $_COOKIE = "cookie";
        $globals = new Globals();
        $this->assertEquals("cookie", $globals->cookie());
        $_COOKIE = "changed";
        $this->assertEquals("changed", $globals->cookie());
    }
    public function testSession() {
        global $_SESSION;
        $_SESSION = "session";
        $globals = new Globals();
        $this->assertEquals("session", $globals->session());
        $_SESSION = "changed";
        $this->assertEquals("changed", $globals->session());
    }
    public function testRequest() {
        global $_REQUEST;
        $_REQUEST = "request";
        $globals = new Globals();
        $this->assertEquals("request", $globals->request());
        $_REQUEST = "changed";
        $this->assertEquals("changed", $globals->request());
    }
    public function testEnv() {
        global $_ENV;
        $_ENV = "env";
        $globals = new Globals();
        $this->assertEquals("env", $globals->env());
        $_ENV = "changed";
        $this->assertEquals("changed", $globals->env());
    }
}