<?php

namespace Tests\HelloWorld\Common\Routes;


use PHPUnit\Framework\TestCase;
use HelloWorld\Common\Routes\Routes as RoutesCommon;


class RoutesTest extends TestCase {
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