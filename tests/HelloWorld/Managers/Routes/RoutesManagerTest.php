<?php

namespace Tests\HelloWorld\Managers\Routes;


use PHPUnit\Framework\TestCase;
use Tests\Utilities\CommonTestUtilities;
use HelloWorld\Contracts\Managers\Routes\RoutesManager as RoutesManagerContract;
use HelloWorld\Managers\Routes\RoutesManager;


class RoutesManagerTest extends TestCase {
    public function testContract() {
        $routesManager = new RoutesManager(null);
        $this->assertEquals(true, $routesManager instanceof RoutesManagerContract);
    }

    public function testGet() {
        $commonTestUtilities = new CommonTestUtilities();
        $routesManager = new RoutesManager(null);

        $reflectionClass = new \ReflectionClass(RoutesManager::class);
        $reflectionProperty = $reflectionClass->getProperty("routesBase");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($routesManager, __DIR__ . "/routes");
        
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

        $this->assertTrue($commonTestUtilities->graphMatching($routesManager->get(), $expectedRoutes));
    }
}