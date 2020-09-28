<?php

namespace Tests\HelloWorld\App;

class DummyController extends \HelloWorld\App\Controllers\Controller {
    public function __construct($app) {
        parent::__construct($app);
    }

    public function index() {
        return $this->app->text("this is home");
    }

    public function show($id) {
        return $this->app->text("showing: " . $id);
    }

    public function store() {
        $id = -1;
        if($this->app->request()->has("id")) {
            $id = $this->app->request()->get("id");
        }
        return $this->app->text("storing: " . $id);
    }
}


use PHPUnit\Framework\TestCase;
use Tests\Utilities\CommonTestUtilities;
use Tests\Utilities\ReflectionUtilities;

use HelloWorld\App\App;
use HelloWorld\Contracts\App\App as AppContract;
use HelloWorld\App\Globals;
use HelloWorld\Managers\Builders\Engines\EnginesManager;
use HelloWorld\App\Incoming\Request;
use HelloWorld\App\Outgoing\Text;
use HelloWorld\Contracts\App\Outgoing\Response;

use HelloWorld\Builders\Engines\Routing\RoutingEngineBuilder;
use HelloWorld\Engines\Routing\RoutingEngine;


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

    public function testRouting() {
        $CommonTestUtilities = new CommonTestUtilities();
        $reflectionUtilities = new ReflectionUtilities();

        $app = new App(null, null);
        $enginesManager = $reflectionUtilities->invokePrivateMethod(
            $app, "getEnginesManager", []
        );
        $reflectionUtilities->setPrivatePropertyValue(
            $enginesManager,
            "builderClasses",
            ["routing" => RoutingEngineBuilder::class]
        );
        $routingEngineBuilder = $reflectionUtilities->invokePrivateMethod(
            $enginesManager,
            "getBuilderObject",
            ["routing"]
        );
        // v.v.i note: we've to enter filtered routes here,
        // cause, routing engine onstructor is injected
        // with filtered routes by RoutesManager
        // remember it well
        // or it'll be a disaster in testing
        $reflectionUtilities->setPrivatePropertyValue(
            $routingEngineBuilder,
            "routes",
            [
                "GET" => [
                    // notice: filtered route, both sides are trimmed and '/'
                    // is also removed from both sides of uri
                    // so, " /api/users/{id}/"(impure/unfiltered) just become
                    // "api/users/{id}"(filtered)
                    "api/users/{id}" => [
                        "name" =>"users.show",
                        "target" => ["controller.users", "show"],
                        "filter" => [
                            "id" => "[A-Za-z0-9_-]+"
                        ]
                    ]
                ]
            ]
        );
        $routing = $app->routing();
        
        $this->assertEquals(
            $routing->resolve("GET", "/api/users/1234"), // here you can use filtered/unfiltered both
            // cause, it is filtered by routing engine itself
            [
                "controller" => ["controller.users", "show"],
                "params" => ["1234"]
            ]
        );
    }


    // no need to test engines() method
    // its similiar as routing() method
    // public function testEngines() {
    // }

    public function testRequest() {
        $app = new App(null, null);
        $this->assertTrue($app->request() instanceof Request);
    }

    public function testText() {
        $app = new App(null, null);
        $this->assertTrue($app->text("") instanceof Text);
    }

    public function testProcess() {
        $CommonTestUtilities = new CommonTestUtilities();
        $reflectionUtilities = new ReflectionUtilities();

        global $_SERVER;
        global $_REQUEST;
        $_SERVER = [];
        $_REQUEST = [];

        $controllerClass = DummyController::class;

        $app = new App(null, new \HelloWorld\App\Globals());
        $enginesManager = $reflectionUtilities->invokePrivateMethod(
            $app, "getEnginesManager", []
        );
        $reflectionUtilities->setPrivatePropertyValue(
            $enginesManager,
            "builderClasses",
            ["routing" => RoutingEngineBuilder::class]
        );
        $routingEngineBuilder = $reflectionUtilities->invokePrivateMethod(
            $enginesManager,
            "getBuilderObject",
            ["routing"]
        );

        // v.v.i note: we've to enter filtered routes here,
        // cause, routing engine onstructor is injected
        // with filtered routes by RoutesManager
        // remember it well
        // or it'll be a disaster in testing
        $reflectionUtilities->setPrivatePropertyValue(
            $routingEngineBuilder,
            "routes",
            [
                "GET" => [
                    // notice: filtered route, both sides are trimmed and '/'
                    // is also removed from both sides of uri
                    // so, " /api/users/{id}/"(impure/unfiltered) just become
                    // "api/users/{id}"(filtered)
                    "" => [
                        "name" =>"root",
                        "target" => [$controllerClass, "index"],
                    ],
                    "index" => [
                        "name" => "index",
                        "target" => [$controllerClass, "index"]
                    ],
                    "home" => [
                        "name" => "home",
                        "target" => [$controllerClass, "index"]
                    ],
                    "show/{id}" => [
                        "name" =>"show",
                        "target" => [$controllerClass, "show"],
                        "filter" => [
                            "id" => "[A-Za-z0-9_-]+"
                        ]
                    ]
                ],
                "POST" => [
                    "store" => [
                        "name" => "store",
                        "target" => [$controllerClass, "store"]
                    ]
                ]
            ]
        );

        // 1st test(testing 'index'):
        // here you can use filtered/unfiltered both
        // cause, it is filtered by routing engine itself
        $_SERVER["REQUEST_URI"] = "/index"; 
        $_SERVER["REQUEST_METHOD"] = "GET";

        $response = $app->process();
        $this->assertEquals(
            "this is home",
            $reflectionUtilities->getPrivatePropertyValue(
                $response, "content"
            )
        );

        // 2nd test(testing 'show/{id}'):
        $_SERVER["REQUEST_URI"] = "/show/123/"; 
        $_SERVER["REQUEST_METHOD"] = "GET";

        $response = $app->process();
        $this->assertEquals(
            "showing: 123",
            $reflectionUtilities->getPrivatePropertyValue(
                $response, "content"
            )
        );

        // 3rd test(testing '/store'):
        $_SERVER["REQUEST_URI"] = "store"; 
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_REQUEST["id"] = 123;

        $response = $app->process();
        $this->assertEquals(
            "storing: 123",
            $reflectionUtilities->getPrivatePropertyValue(
                $response, "content"
            )
        );
    }
}
