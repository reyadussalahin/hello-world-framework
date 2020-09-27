<?php

namespace Tests\HelloWorld\Managers\Routes;


use PHPUnit\Framework\TestCase;
use Tests\Utility\TestUtility;
use HelloWorld\Contracts\Managers\Routes\Routes as RoutesContract;
use HelloWorld\Managers\Routes\Routes;


class RoutesTest extends TestCase {
    public function testContract() {
        $routes = new Routes(__DIR__ . "/routes");
        $this->assertEquals(true, $routes instanceof RoutesContract);
    }

    public function testGet() {
        $testUtility = new TestUtility();

        $routes = new Routes(__DIR__ . "/routes");
        
        $expectedRoutes = [
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
            ],

            "PUT" => [
                "api/users/{id}" => [
                    "name" => "users.update",
                    "target"=> ["api.users", "update"],
                    "filter" => [
                        "id" => "[A-Za-z0-9_-]+"
                    ]
                ]
            ]
        ];

        $this->assertTrue($testUtility->graphMatching($routes->get(), $expectedRoutes));
    }
}