<?php

namespace Mason\Dialect\MySQL\Expression;

class NullTest extends \PHPUnit_Framework_TestCase
{
    public function testCompileFalse()
    {
        $stm = $this->getMockForAbstractClass(
            'Mason\Statement', 
            array(), '', true, true, true,
            array('compile')
        );

        $clause = new Null($stm);
        $actual = $clause->__toString(false);
        $this->assertEquals('NULL', $actual);
    }
}
