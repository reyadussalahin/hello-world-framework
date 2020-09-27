<?php

namespace Tests\HelloWorld\Builders\Engines\Routing;


use PHPUnit\Framework\TestCase;
use Tests\Utility\TestUtility;
use HelloWorld\Contracts\Builders\Builder as BuilderContract;
use HelloWorld\Builders\Engines\Routing\EngineBuilder as RoutingEngineBuilder;
use HelloWorld\Engines\Routing\Engine as RoutingEngine;


class EngineBuilderTest extends TestCase {
    public function testContract() {
        $engineBuilder = new RoutingEngineBuilder(null);
        $this->assertTrue($engineBuilder instanceof BuilderContract);
    }

    public function testGet() {
        $testUtility = new TestUtility();
        $engineBuilder = new RoutingEngineBuilder(null);

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

        $reflectionClass = new \ReflectionClass(RoutingEngineBuilder::class);
        $reflectionProperty = $reflectionClass->getProperty("routes");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($engineBuilder, $routes);
        
        $engine = $engineBuilder->get();
        $this->assertTrue($engine instanceof RoutingEngine);
        
        $uri = "/api/users/1234";
        $expected = [
            "controller" => ["api.users", "show"],
            "params" => ["1234"]
        ];
        $this->assertTrue(
            $testUtility->graphMatching(
                $expected, $engine->resolve("GET", $uri)
            )
        );
    }
}