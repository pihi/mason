<?php

namespace Mason\Scaffold\Clause;

class LimitTest extends \PHPUnit_Framework_TestCase
{
    public function testSetLimit()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Statement'
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Limit',
            array($statement)
        );

        $res = $clause->setLimit(5);
        $this->assertSame($clause, $res);

        $refl = new \ReflectionClass($clause);
        $prop = $refl->getProperty('limit');
        $prop->setAccessible(true);

        $this->assertEquals(5, $prop->getValue($clause));
    }

    public function testSetOffset()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Statement'
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Limit',
            array($statement)
        );

        $res = $clause->setOffset(5);
        $this->assertSame($clause, $res);

        $refl = new \ReflectionClass($clause);
        $prop = $refl->getProperty('offset');
        $prop->setAccessible(true);

        $this->assertEquals(5, $prop->getValue($clause));
    }
}
