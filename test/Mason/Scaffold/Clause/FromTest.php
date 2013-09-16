<?php

namespace Mason\Scaffold\Clause;

class FromTest extends \PHPUnit_Framework_TestCase
{
    public function testAddTable()
    {
        $table = $this->getMock('Mason\Alias',
            array(), array('test', 't'));

        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true,
            array('table')
        );

        $statement->expects($this->once())
            ->method('table')
            ->with(
                $this->equalTo('test'),
                $this->equalTo('t')
            )
            ->will($this->returnValue($table));

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\From',
            array($statement), '', true, true, true
        );

        $clause->addTable('test', 't');
        $clause->addTable($table);
    }

    public function testAddTableAsArray()
    {
        $table = $this->getMock('Mason\Alias',
            array(), array('test', 't'));

        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true,
            array('table')
        );

        $statement->expects($this->once())
            ->method('table')
            ->with(
                $this->equalTo('test'),
                $this->equalTo('t')
            )
            ->will($this->returnValue($table));

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\From',
            array($statement), '', true, true, true
        );

        $clause->addTable(array('test', 't'));
    }

    public function testAddTableWithStatement()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true
        );

        $statement2 = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\From',
            array($statement), '', true, true, true,
            array('canUseSubquery')
        );

        $clause->expects($this->once())
            ->method('canUseSubquery')
            ->will($this->returnValue(true));

        $clause->addTable($statement2, 'a');
    }

    /**
     * @expectedException \Mason\InvalidStateException
     */
    public function testAddTableWithStatementCannotSubquery()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true
        );

        $statement2 = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\From',
            array($statement), '', true, true, true,
            array('canUseSubquery')
        );

        $clause->expects($this->once())
            ->method('canUseSubquery')
            ->will($this->returnValue(false));

        $clause->addTable($statement2, 'a');
    }

    /**
     * @expectedException \Mason\InvalidStateException
     */
    public function testAddTableWithStatementWithoutAlias()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true
        );

        $statement2 = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\From',
            array($statement), '', true, true, true,
            array('canUseSubquery')
        );

        $clause->expects($this->once())
            ->method('canUseSubquery')
            ->will($this->returnValue(true));

        $clause->addTable($statement2);
    }

    /**
     * @expectedException \Mason\InvalidStateException
     */
    public function testAddTableWithStatementRecursion()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\From',
            array($statement), '', true, true, true,
            array('canUseSubquery')
        );

        $clause->expects($this->once())
            ->method('canUseSubquery')
            ->will($this->returnValue(true));

        $clause->addTable($statement, 'a');
    }
}
