<?php

namespace Tests\Utilities;


class ReflectionUtilities {
    public function setPrivatePropertyValue($obj, $propertyName, $propertyValue) {
        $reflectionClass = new \ReflectionClass($obj);
        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($obj, $propertyValue);
    }
    
    public function getPrivatePropertyValue($obj, $propertyName) {
        $reflectionClass = new \ReflectionClass($obj);
        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty->getValue($obj);
    }

    public function invokePrivateMethod($obj, $method, $params) {
        $reflectionMethod = new \ReflectionMethod($obj, $method);
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invokeArgs($obj, $params);
    }
}