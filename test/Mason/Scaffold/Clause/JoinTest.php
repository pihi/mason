<?php

namespace Mason\Scaffold\Clause;

class JoinTest extends \PHPUnit_Framework_TestCase
{
    public function testAddJoin()
    {
        $table = $this->getMock('Mason\Alias',
            array(), array('test', 't'));

        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true,
            array('table')
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Join',
            array($statement), '', true, true, true,
            array('getWhereClause')
        );

        $where = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($statement), '', true, true, true,
            array('addCondition')
        );

        $clause->expects($this->any())
            ->method('getWhereClause')
            ->will($this->returnValue($where));

        $clause->addJoin('inner', 'test', 'id', 'id2', '=');
    }

    /**
     * @expectedException \Mason\InvalidStateException
     */
    public function testAddJoinWithoutValue()
    {
        $table = $this->getMock('Mason\Alias',
            array(), array('test', 't'));

        $statement = $this->getMockForAbstractClass(
            'Mason\Statement',
            array(), '', true, true, true,
            array('table')
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Join',
            array($statement), '', true, true, true,
            array('getWhereClause')
        );

        $where = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($statement), '', true, true, true,
            array('addCondition')
        );

        $clause->expects($this->any())
            ->method('getWhereClause')
            ->will($this->returnValue($where));

        $clause->addJoin('inner', 'test', 'id', null);
    }
}
