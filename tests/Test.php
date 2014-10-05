<?php

require_once __DIR__.'/../vendor/autoload.php';

abstract class Test extends PHPUnit_Framework_TestCase {

    public function eq($expected, $actual)
    {
        $this->assertEquals($expected, (string) $actual);
    }

} 