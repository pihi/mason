<?php

namespace Mason\Dialect\MySQL;

class SelectorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $s1 = new Selector();
        $s2 = new Selector();

        $this->assertNotEquals($s1->getInstanceId(), $s2->getInstanceId());
        $this->assertGreaterThan(0, $s1->getInstanceId());
        $this->assertGreaterThan(0, $s2->getInstanceId());
    }

    public function testCompile()
    {
        $select = $this->getMockBuilder('Mason\Dialect\MySQL\Clause\Select')
            ->disableOriginalConstructor()
            ->setMethods(array('__toString'))
            ->getMock();
        $from = $this->getMockBuilder('Mason\Dialect\MySQL\Clause\From')
            ->disableOriginalConstructor()
            ->setMethods(array('__toString'))
            ->getMock();
        $join = $this->getMockBuilder('Mason\Dialect\MySQL\Clause\Join')
            ->disableOriginalConstructor()
            ->setMethods(array('__toString'))
            ->getMock();
        $where = $this->getMockBuilder('Mason\Dialect\MySQL\Clause\Where')
            ->disableOriginalConstructor()
            ->setMethods(array('__toString'))
            ->getMock();
        $group = $this->getMockBuilder('Mason\Dialect\MySQL\Clause\GroupBy')
            ->disableOriginalConstructor()
            ->setMethods(array('__toString'))
            ->getMock();
        $having = $this->getMockBuilder('Mason\Dialect\MySQL\Clause\Having')
            ->disableOriginalConstructor()
            ->setMethods(array('__toString'))
            ->getMock();
        $order = $this->getMockBuilder('Mason\Dialect\MySQL\Clause\OrderBy')
            ->disableOriginalConstructor()
            ->setMethods(array('__toString'))
            ->getMock();
        $limit = $this->getMockBuilder('Mason\Dialect\MySQL\Clause\Limit')
            ->disableOriginalConstructor()
            ->setMethods(array('__toString'))
            ->getMock();

        $select->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('(SELECT)'));

        $from->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('(FROM)'));

        $join->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('(JOIN)'));

        $where->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('(WHERE)'));

        $group->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('(GROUP)'));

        $having->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('(HAVING)'));

        $order->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('(ORDER)'));

        $limit->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('(LIMIT)'));

        $expected = "SELECT (SELECT) FROM (FROM) (JOIN) WHERE (WHERE) GROUP BY (GROUP) HAVING (HAVING) ORDER BY (ORDER) LIMIT (LIMIT)";
        $stm = new Selector($select, $from, $join, $where, $group, $having, $order, $limit);
        $actual = (string)$stm;
        $this->assertEquals($expected, $actual);
    }
}
