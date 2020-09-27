<?php

namespace Tests\HelloWorld\Managers\Builders\Engines;


use PHPUnit\Framework\TestCase;
use HelloWorld\Contracts\Managers\Builders\Engines\EnginesManager as EnginesManagerContract;
use HelloWorld\Managers\Builders\Engines\EnginesManager;
use HelloWorld\Builders\Engines\Routing\RoutingEngineBuilder;


class EnginesManagerTest extends TestCase {
    public function testContract() {
        $enginesManager = new EnginesManager(null);
        $this->assertTrue($enginesManager instanceof EnginesManagerContract);
    }
    
    public function testGet() {
        $enginesManager = new EnginesManager(null);

        $reflectionClass = new \ReflectionClass(EnginesManager::class);
        $reflectionProperty = $reflectionClass->getProperty("buildersBase");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($enginesManager, __DIR__ . "/builders/engines");

        $reflectionMethod = new \ReflectionMethod(EnginesManager::class, "getBuilderObject");
        $reflectionMethod->setAccessible(true);

        $builder = $reflectionMethod->invoke($enginesManager, "routing");
        
        $this->assertTrue($builder instanceof RoutingEngineBuilder);
    }
}