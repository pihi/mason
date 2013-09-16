<?php

namespace Mason\Scaffold\Clause;

class GroupByTest extends \PHPUnit_Framework_TestCase
{
    public function testAddGroup()
    {
        $field = $this->getMockBuilder('Mason\Alias')
            ->disableOriginalConstructor()
            ->getMock();

        $statement = $this->getMockForAbstractClass(
            'Mason\Scaffold\Statement',
            array(), '', true, true, true,
            array('construct', 'field')
        );

        $statement->expects($this->once())
            ->method('field')
            ->with($this->equalTo('test'))
            ->will($this->returnValue($field));

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\GroupBy',
            array($statement), '', true, true, true
        );

        $clause->addGroup('test');
    }

    public function testAddGroupWithMasonry()
    {
        $masonry = $this->getMockBuilder('Mason\Masonry')
            ->disableOriginalConstructor()
            ->getMock();

        $expression = $this->getMockForAbstractClass(
            'Mason\Expression'
        );

        $statement = $this->getMockForAbstractClass(
            'Mason\Scaffold\Statement',
            array(), '', true, true, true,
            array('construct', 'field')
        );

        $statement->expects($this->once())
            ->method('construct')
            ->with($this->equalTo($masonry))
            ->will($this->returnValue($expression));

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\GroupBy',
            array($statement), '', true, true, true
        );

        $clause->addGroup($masonry);
    }

}
