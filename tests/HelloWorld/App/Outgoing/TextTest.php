<?php

namespace Tests\HelloWorld\App\Outgoing;


use PHPUnit\Framework\TestCase;
use HelloWorld\Contracts\App\Outgoing\Response;
use HelloWorld\App\Outgoing\Text;


class TextTest extends TestCase {
    public function testContract() {
        $text = new Text(null, "some text");
        $this->assertTrue($text instanceof Response);
    }

    public function testContent() {
        $text = new Text(null, "some text");
        $expected = "some text";

        $reflectionClass = new \ReflectionClass(Text::class);
        $reflectionProperty = $reflectionClass->getProperty("content");
        $reflectionProperty->setAccessible(true);

        $this->assertEquals($expected, $reflectionProperty->getValue($text));
    }
}