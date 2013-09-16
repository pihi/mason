<?php

namespace Mason\Scaffold;

class SelectorTest extends \PHPUnit_Framework_TestCase
{
    public function testFrom()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\From', 
            array($selector), 
            '', true, true, true, 
            array('addTable'));

        $clause->expects($this->once())
            ->method('addTable')
            ->will($this->returnValue(null));

        $selector->expects($this->once())
            ->method('getFromClause')
            ->will($this->returnValue($clause));

        $stm = $selector->from('test');
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);
    }

    public function testFromWithMultipleArgs()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\From', 
            array($selector), 
            '', true, true, true, 
            array('addTable'));

        $clause->expects($this->exactly(3))
            ->method('addTable');

        $selector->expects($this->once())
            ->method('getFromClause')
            ->will($this->returnValue($clause));

        $stm = $selector->from('test1','test2','test3');
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);
    }

    public function testSelect()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Select', 
            array($selector), 
            '', true, true, true, 
            array('addField'));

        $clause->expects($this->once())
            ->method('addField')
            ->will($this->returnValue(null));

        $selector->expects($this->once())
            ->method('getSelectClause')
            ->will($this->returnValue($clause));

        $stm = $selector->select('test');
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);
    }

    public function testSelectWithMultipleArgs()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Select', 
            array($selector), 
            '', true, true, true, 
            array('addField'));

        $clause->expects($this->exactly(3))
            ->method('addField');

        $selector->expects($this->once())
            ->method('getSelectClause')
            ->will($this->returnValue($clause));

        $stm = $selector->select('test1','test2','test3');
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);
    }

    public function testJoin()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Join',
            array($selector),
            '', true, true, true,
            array('addJoin')
        );

        $on = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($selector),
            '', true, true, true
        );

        $clause->expects($this->at(0))
            ->method('addJoin')
            ->with(
                $this->equalTo('inner'),
                $this->equalTo('test'),
                $this->equalTo($on)
            );

        $clause->expects($this->at(1))
            ->method('addJoin')
            ->with(
                $this->equalTo('inner'),
                $this->equalTo('test'),
                $this->equalTo($on)
            );

        $clause->expects($this->at(2))
            ->method('addJoin')
            ->with(
                $this->equalTo('outer'),
                $this->equalTo('test'),
                $this->equalTo($on)
            );

        $clause->expects($this->at(3))
            ->method('addJoin')
            ->with(
                $this->equalTo('left'),
                $this->equalTo('test'),
                $this->equalTo($on)
            );

        $clause->expects($this->at(4))
            ->method('addJoin')
            ->with(
                $this->equalTo('right'),
                $this->equalTo('test'),
                $this->equalTo($on)
            );

        $selector->expects($this->any())
            ->method('getJoinClause')
            ->will($this->returnValue($clause));

        $stm = $selector->join('test', $on);
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);

        $stm = $selector->inner('test', $on);
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);

        $stm = $selector->outer('test', $on);
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);

        $stm = $selector->left('test', $on);
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);

        $stm = $selector->right('test', $on);
        $this->assertInstanceOf('Mason\Scaffold\Selector', $stm);
    }

    public function testWhere()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($selector),
            '', true, true, true,
            array('addCondition')
        );

        $clause->expects($this->once())
            ->method('addCondition')
            ->with(
                $this->equalTo('field'),
                $this->equalTo('value'),
                $this->equalTo('=')
            );

        $selector->expects($this->any())
            ->method('getWhereClause')
            ->will($this->returnValue($clause));

        $stm = $selector->where('field', 'value', '=');
        $this->assertSame($selector, $stm);

        $whr = $selector->where();
        $this->assertSame($clause, $whr);
    }

    public function testGroupBy()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\GroupBy',
            array($selector),
            '', true, true, true,
            array('addGroup')
        );

        $clause->expects($this->once())
            ->method('addGroup')
            ->with(
                $this->equalTo('field')
            );

        $selector->expects($this->any())
            ->method('getGroupByClause')
            ->will($this->returnValue($clause));

        $stm = $selector->groupBy('field');
        $this->assertSame($selector, $stm);
    }

    public function testHaving()
    {
        /*
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Having',
            array($selector),
            '', true, true, true,
            array('add
        );

        $clause->expects($this->once())
            ->with(
                $this->equalTo('field'),
                $this->equalTo('desc')
            )
            ->method('addOrder');

        $stm = $selector->having('field', 'value');
        $this->assertSame($selector, $stm);
        */
    }

    public function testOrderBy()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\OrderBy',
            array($selector),
            '', true, true, true,
            array('addOrder')
        );

        $clause->expects($this->once())
            ->method('addOrder')
            ->with(
                $this->equalTo('field'),
                $this->equalTo('desc')
            );

        $selector->expects($this->any())
            ->method('getOrderByClause')
            ->will($this->returnValue($clause));

        $stm = $selector->orderBy('field', 'desc');
        $this->assertSame($selector, $stm);
    }

    public function testLimit()
    {
        $selector = $this->getMockForAbstractClass('Mason\Scaffold\Selector');

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Limit',
            array($selector),
            '', true, true, true,
            array('setLimit','setOffset')
        );

        $clause->expects($this->once())
            ->method('setLimit')
            ->with($this->equalTo(10));

        $clause->expects($this->once())
            ->method('setOffset')
            ->with($this->equalTo(10));

        $selector->expects($this->any())
            ->method('getLimitClause')
            ->will($this->returnValue($clause));

        $stm = $selector->limit(10, 10);
        $this->assertSame($selector, $stm);
    }
}
