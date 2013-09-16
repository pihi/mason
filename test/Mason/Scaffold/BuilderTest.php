<?php

namespace Mason\Scaffold;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testFrom()
    {
        $selector = $this->getMockForAbstractClass(
            'Mason\\Selector',
            array(), '', true, true, true,
            array('from')
        );

        $selector->expects($this->once())
            ->method('from')
            ->with($this->equalTo('test'));

        $builder = $this->getMockForAbstractClass(
            'Mason\\Scaffold\\Builder',
            array(), '', true, true, true,
            array('getSelector')
        );

        $builder->expects($this->once())
            ->method('getSelector')
            ->will($this->returnValue($selector));

        $sel = $builder->from('test');

        $this->assertSame($selector, $sel);
    }

    public function testFromWithMultipleTables()
    {
        $selector = $this->getMockForAbstractClass(
            'Mason\\Selector',
            array(), '', true, true, true,
            array('from')
        );

        $selector->expects($this->at(0))
            ->method('from')
            ->with($this->equalTo('test'));

        $selector->expects($this->at(1))
            ->method('from')
            ->with($this->equalTo('test2'));

        $builder = $this->getMockForAbstractClass(
            'Mason\\Scaffold\\Builder',
            array(), '', true, true, true,
            array('getSelector')
        );

        $builder->expects($this->once())
            ->method('getSelector')
            ->will($this->returnValue($selector));

        $sel = $builder->from('test','test2');

        $this->assertSame($selector, $sel);
    }

    public function testUpdate()
    {
        $updater = $this->getMockForAbstractClass(
            'Mason\\Updater',
            array(), '', true, true, true,
            array('update')
        );

        $updater->expects($this->once())
            ->method('update')
            ->with($this->equalTo('test'));

        $builder = $this->getMockForAbstractClass(
            'Mason\\Scaffold\\Builder',
            array(), '', true, true, true,
            array('getUpdater')
        );

        $builder->expects($this->once())
            ->method('getUpdater')
            ->will($this->returnValue($updater));

        $upd = $builder->update('test');

        $this->assertSame($updater, $upd);
    }

    public function testUpdateWithMultipleTables()
    {
        $updater = $this->getMockForAbstractClass(
            'Mason\\Updater',
            array(), '', true, true, true,
            array('update')
        );

        $updater->expects($this->at(0))
            ->method('update')
            ->with($this->equalTo('test'));

        $updater->expects($this->at(1))
            ->method('update')
            ->with($this->equalTo('test2'));

        $builder = $this->getMockForAbstractClass(
            'Mason\\Scaffold\\Builder',
            array(), '', true, true, true,
            array('getUpdater')
        );

        $builder->expects($this->once())
            ->method('getUpdater')
            ->will($this->returnValue($updater));

        $upd = $builder->update('test','test2');

        $this->assertSame($updater, $upd);
    }

    public function testInsert()
    {
        $inserter = $this->getMockForAbstractClass(
            'Mason\\Inserter',
            array(), '', true, true, true,
            array('inserter')
        );

        $inserter->expects($this->once())
            ->method('insert')
            ->with($this->equalTo('test'));

        $builder = $this->getMockForAbstractClass(
            'Mason\\Scaffold\\Builder',
            array(), '', true, true, true,
            array('getInserter')
        );

        $builder->expects($this->once())
            ->method('getInserter')
            ->will($this->returnValue($inserter));

        $ins = $builder->insert('test');

        $this->assertSame($inserter, $ins);
    }

    public function testInsertInto()
    {
        $inserter = $this->getMockForAbstractClass(
            'Mason\\Inserter',
            array(), '', true, true, true,
            array('inserter')
        );

        $inserter->expects($this->once())
            ->method('insert')
            ->with($this->equalTo('test'));

        $builder = $this->getMockForAbstractClass(
            'Mason\\Scaffold\\Builder',
            array(), '', true, true, true,
            array('getInserter')
        );

        $builder->expects($this->once())
            ->method('getInserter')
            ->will($this->returnValue($inserter));

        $ins = $builder->insertInto('test');

        $this->assertSame($inserter, $ins);
    }
}
