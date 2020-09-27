<?php

namespace Tests\HelloWorld\Builders\Engines\Routing;


use PHPUnit\Framework\TestCase;
use Tests\Utilities\CommonTestUtilities;
use HelloWorld\Contracts\Builders\Builder as BuilderContract;
use HelloWorld\Builders\Engines\Routing\RoutingEngineBuilder;
use HelloWorld\Engines\Routing\RoutingEngine;


class RoutingEngineBuilderTest extends TestCase {
    public function testContract() {
        $builder = new RoutingEngineBuilder(null);
        $this->assertTrue($builder instanceof BuilderContract);
    }

    public function testGet() {
        $commonTestUtilities = new CommonTestUtilities();
        $builder = new RoutingEngineBuilder(null);

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
        $reflectionProperty->setValue($builder, $routes);
        
        $engine = $builder->get();
        $this->assertTrue($engine instanceof RoutingEngine);
        
        $uri = "/api/users/1234";
        $expected = [
            "controller" => ["api.users", "show"],
            "params" => ["1234"]
        ];
        $this->assertTrue(
            $commonTestUtilities->graphMatching(
                $expected, $engine->resolve("GET", $uri)
            )
        );
    }
}