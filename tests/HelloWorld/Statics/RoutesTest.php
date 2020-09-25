<?php

namespace Tests\HelloWorld\Statics;


use PHPUnit\Framework\TestCase;
use HelloWorld\Contracts\Statics\Routes as RoutesContract;
use HelloWorld\Statics\Routes;


class RoutesTest extends TestCase {
    public function testContract() {
        $routes = new Routes(__DIR__ . "/routes");
        $this->assertEquals(true, $routes instanceof RoutesContract);
    }

    private function graphMatching($a, $b) {
        if(is_array($a) && is_array($b)) {
            foreach($a as $k => $v) {
                if(isset($b[$k])) {
                    return $this->graphMatching($v, $b[$k]);
                } else {
                    return false;
                }
            }
        }
        return ($a === $b);
    }

    public function testGet() {
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

        $this->assertTrue($this->graphMatching($routes->get(), $expectedRoutes));
    }
}