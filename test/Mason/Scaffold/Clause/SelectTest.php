<?php

namespace Mason\Scaffold\Clause;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    public function testAddField()
    {
        $field = $this->getMock('Mason\Alias',
            array(), array('test', 't'));

        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true,
            array('field')
        );

        $statement->expects($this->once())
            ->method('field')
            ->with(
                $this->equalTo('test'),
                $this->equalTo('t')
            )
            ->will($this->returnValue($field));

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Select',
            array($statement), '', true, true, true
        );

        $clause->addField('test', 't');
        $clause->addField($field);
    }

    public function testAddFieldAsArray()
    {
        $field = $this->getMock('Mason\Alias',
            array(), array('test', 't'));

        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true,
            array('field')
        );

        $statement->expects($this->once())
            ->method('field')
            ->with(
                $this->equalTo('test'),
                $this->equalTo('t')
            )
            ->will($this->returnValue($field));

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Select',
            array($statement), '', true, true, true
        );

        $clause->addField(array('test', 't'));
    }

    public function testAddMasonry()
    {
        $field = $this->getMock('Mason\Alias',
            array(), array('test', 't'));

        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true,
            array('field')
        );

        $masonry = $this->getMockBuilder('Mason\Masonry')
            ->disableOriginalConstructor()
            ->getMock();

        $expression = $this->getMockForAbstractClass(
            'Mason\Expression',
            array(), '', true, true, true,
            array()
        );

        $statement->expects($this->once())
            ->method('field')
            ->with(
                $this->equalTo($expression),
                $this->equalTo('t')
            )
            ->will($this->returnValue($field));

        $statement->expects($this->once())
            ->method('construct')
            ->with($this->equalTo($masonry))
            ->will($this->returnValue($expression));

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Select',
            array($statement), '', true, true, true
        );

        $clause->addField($masonry, 't');
    }
}
