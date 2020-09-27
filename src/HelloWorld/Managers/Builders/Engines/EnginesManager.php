<?php

namespace HelloWorld\Managers\Builders\Engines;


use HelloWorld\Contracts\Managers\Builders\Engines\EnginesManager as EnginesManagerContract;


class EnginesManager implements EnginesManagerContract {
    private $app;
    private $buildersBase;
    private $builderClasses;
    private $builderObjects;

    public function __construct($app) {
        $this->app = $app;
    }

    private function getBuildersBase() {
        if($this->buildersBase === null) {
            $this->buildersBase = $this->app->base() . "/builders/engines";
        }
        return $this->buildersBase;
    }

    private function getBuilderClass($builderName) {
        if($this->builderClasses === null) {
            $this->builderClasses = require $this->getBuildersBase() . "/engines.php";
        }
        return $this->builderClasses[$builderName];
    }

    private function getBuilderObject($builderName) {
        if($this->builderObjects === null) {
            $this->builderObjects = [];
        }
        if(!isset($this->builderObjects[$builderName])) {
            $builderClass = $this->getBuilderClass($builderName);
            $this->builderObjects[$builderName] = new $builderClass($this->app);
        }
        return $this->builderObjects[$builderName];
    }

    public function get($engineName) {
        return $this->getBuilderObject($engineName)->get();
    }
}