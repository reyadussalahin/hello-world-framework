<?php

namespace Tests\HelloWorld\Routing;


use PHPUnit\Framework\TestCase;
use Tests\Utility\TestUtility;
use HelloWorld\Contracts\Engines\Routing\Engine as RoutingEngineContract;
use HelloWorld\Engines\Routing\Engine as RoutingEngine;


class EngineTest extends TestCase {
    public function testContract() {
        $routingEngine = new RoutingEngine(null);
        $this->assertTrue($routingEngine instanceof RoutingEngineContract);
    }

    public function testResolve() {
        $testUtility = new TestUtility();

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
                        "id" => "[A-Za-z0-9_-]+"
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
            "params" => [1234]
        ];
        $this->assertTrue(
            $testUtility->graphMatching(
                $expected, $routingEngine->resolve("GET", $uri)
            )
        );
        $this->assertFalse(
            $testUtility->graphMatching(
                $expected, $routingEngine->resolve("POST", $uri)
            )
        );

        $uri = "/users/ create/";
        $expected = [
            "controller" => ["users", "create"],
            "params" => []
        ];
        $this->assertTrue(
            $testUtility->graphMatching(
                $expected, $routingEngine->resolve("POST", $uri)
            )
        );
        $this->assertFalse(
            $testUtility->graphMatching(
                $expected, $routingEngine->resolve("GET", $uri)
            )
        );

        $uri = "out-of-the-world-uri";
        $this->assertTrue(
            $testUtility->graphMatching(
                null, $routingEngine->resolve("POST", $uri)
            )
        );
    }
}