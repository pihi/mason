<?php

namespace Mason;

class AliasTest extends \PHPUnit_Framework_TestCase
{
    public function testAlias()
    {
        $alias = new Alias('test', 't');
        $this->assertEquals('test', $alias->getName());
        $this->assertEquals('t', $alias->getAlias());
    }
}
