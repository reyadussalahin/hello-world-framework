<?php

namespace Tests\HelloWorld\Commons\Routes;


use PHPUnit\Framework\TestCase;
use HelloWorld\Commons\Routes\RoutesCommon;


class RoutesCommonTest extends TestCase {
    public function testContract() {
        $routesCommon = new RoutesCommon();
        $this->assertTrue($routesCommon instanceof RoutesCommon);
    }
    public function testFilterUri() {
        $uri = " /api/users/{id}/ ";
        $expected = "api/users/{id}";
        $routesCommon = new RoutesCommon();
        $this->assertEquals($expected, $routesCommon->filterUri($uri));
    }
}