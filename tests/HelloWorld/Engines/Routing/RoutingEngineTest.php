<?php

namespace Tests\HelloWorld\Routing;


use PHPUnit\Framework\TestCase;
use Tests\Utilities\CommonTestUtilities;
use HelloWorld\Contracts\Engines\Routing\RoutingEngine as RoutingEngineContract;
use HelloWorld\Engines\Routing\RoutingEngine;


class RoutingEngineTest extends TestCase {
    public function testContract() {
        $routingEngine = new RoutingEngine(null);
        $this->assertTrue($routingEngine instanceof RoutingEngineContract);
    }

    public function testResolve() {
        $commonTestUtilities = new CommonTestUtilities();

        $routes = [
            "GET" => [
                "users" => [
                    "name" => "users.all",
                    "target" => ["users", "index"]
                ],
                "api/users/{id}" => [
                    "name" => "users.show",
                    "target" => ["api.users", "show"],
                    "filter" => [
                        // "id" => "[A-Za-z0-9_-]+"

                        // allow only digits and
                        // there should be atleast one digit
                        "id" => "[0-9]+"
                    ]
                ]
            ],

            "POST" => [
                "users/create" => [
                    "name" => "users.create",
                    "target"=> ["users", "create"]
                ]
            ]
        ];

        $routingEngine = new RoutingEngine($routes);

        $uri = "/api/users/1234";
        $expected = [
            "controller" => ["api.users", "show"],
            "params" => ["1234"]
        ];
        $this->assertTrue(
            $commonTestUtilities->graphMatching(
                $expected, $routingEngine->resolve("GET", $uri)
            )
        );
        $this->assertFalse(
            $commonTestUtilities->graphMatching(
                $expected, $routingEngine->resolve("POST", $uri)
            )
        );
        
        $uri = "/api/users/2wab";
        // note: for this uri routing engine would return null
        //       cause, id filter can passes numbers, cannot pass any
        //       other chars
        $this->assertTrue(
            $commonTestUtilities->graphMatching(
                null, $routingEngine->resolve("POST", $uri)
            )
        );
        

        $uri = "/users/ create/";
        $expected = [
            "controller" => ["users", "create"],
            "params" => []
        ];
        $this->assertTrue(
            $commonTestUtilities->graphMatching(
                $expected, $routingEngine->resolve("POST", $uri)
            )
        );
        $this->assertFalse(
            $commonTestUtilities->graphMatching(
                $expected, $routingEngine->resolve("GET", $uri)
            )
        );

        $uri = "out-of-the-world-uri";
        $this->assertTrue(
            $commonTestUtilities->graphMatching(
                null, $routingEngine->resolve("POST", $uri)
            )
        );
    }
}