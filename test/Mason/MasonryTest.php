<?php

namespace Mason;

class MasonryTest extends \PHPUnit_Framework_TestCase
{
    public function testExpression()
    {
        $m = Masonry::expression("EXP");
        $this->assertEquals("EXP", $m->getExpression());
        $this->assertTrue($m->isPlain());
        $this->assertNull($m->getArguments());
    }

    public function testNamedExpression()
    {
        $m = Masonry::test('1', '2');
        $this->assertEquals('test', $m->getExpression());
        $this->assertFalse($m->isPlain());
        $this->assertEquals(array('1','2'), $m->getArguments());
    }
}
