<?php

namespace Mason\Scaffold;

class ClauseTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause', 
            array(), '', false, true, true,
            array('compile')
        );

        $clause->expects($this->once())
            ->method('compile')
            ->with($this->equalTo(false))
            ->will($this->returnValue('CLAUSE'));

        $actual = $clause->__toString();
        $this->assertEquals('CLAUSE', $actual);
    }
}
