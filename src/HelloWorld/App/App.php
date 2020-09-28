<?php

namespace HelloWorld\App;


use HelloWorld\Contracts\App\App as AppContract;
use HelloWorld\Managers\Builders\Engines\EnginesManager;
use HelloWorld\App\Incoming\Request;
use HelloWorld\App\Outgoing\Text;


class App implements AppContract {
    private $base;
    private $globals;
    private $enginesManager;
    private $request;
    private $text;

    public function __construct($base, $globals) {
        $this->base = $base;
        $this->globals = $globals;
    }

    public function base() {
        return $this->base;
    }

    public function globals() {
        return $this->globals;
    }

    private function getEnginesManager() {
        if($this->enginesManager === null) {
            $this->enginesManager = new EnginesManager($this);
        }
        return $this->enginesManager;
    }

    public function routing() {
        return $this->getEnginesManager()->get("routing");
    }

    public function engines($engineName) {
        return $this->getEnginesManager()->get($engineName);
    }

    public function request() {
        if($this->request === null) {
            $this->request = new Request($this);
        }
        return $this->request;
    }

    public function text($text) {
        return new Text($this, $text);
    }

    public function process() {
        $target = $this->routing()->resolve(
            $this->request()->method(),
            $this->request()->uri()
        );

        $controller = new $target["controller"][0](
            $this
        );

        return $controller->{$target["controller"][1]}(
            ...$target["params"]
        );
    }
}