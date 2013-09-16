<?php

namespace Mason\Scaffold\Clause;

class WhereTest extends \PHPUnit_Framework_TestCase
{
    public function testAddAnd()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Query',
            array(), '', true, true, true
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($statement), '', true, true, true
        );

        $refl = new \ReflectionClass($clause);
        $cond = $refl->getProperty('conditions');
        $cond->setAccessible(true);
        $mode = $refl->getProperty('mode');
        $mode->setAccessible(true);

        $newClause = $clause->addAnd();
        $this->assertInstanceOf('Mason\Scaffold\Clause\Where', $newClause);
        $this->assertEquals(1, count($cond->getValue($clause)));
        $this->assertEquals('AND', $mode->getValue($newClause));

        $newClause = $clause->and();
        $this->assertInstanceOf('Mason\Scaffold\Clause\Where', $newClause);
        $this->assertEquals(2, count($cond->getValue($clause)));
        $this->assertEquals('AND', $mode->getValue($newClause));
    }

    public function testAddOr()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Query',
            array(), '', true, true, true
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($statement), '', true, true, true
        );

        $refl = new \ReflectionClass($clause);
        $cond = $refl->getProperty('conditions');
        $cond->setAccessible(true);
        $mode = $refl->getProperty('mode');
        $mode->setAccessible(true);

        $newClause = $clause->addOr();
        $this->assertInstanceOf('Mason\Scaffold\Clause\Where', $newClause);
        $this->assertEquals(1, count($cond->getValue($clause)));
        $this->assertEquals('OR', $mode->getValue($newClause));

        $newClause = $clause->or();
        $this->assertInstanceOf('Mason\Scaffold\Clause\Where', $newClause);
        $this->assertEquals(2, count($cond->getValue($clause)));
        $this->assertEquals('OR', $mode->getValue($newClause));
    }

    public function testCallParentMethod()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Query',
            array('orderBy'), '', true, true, true
        );

        $statement->expects($this->any())
            ->method('orderBy')
            ->will($this->returnValue(true));

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($statement), '', true, true, true
        );

        $this->assertTrue($clause->orderBy('test'));

        $newClause = $clause->addAnd();
        $this->assertTrue($newClause->orderBy('test'));

        $anotherClause = $newClause->addOr();
        $this->assertTrue($anotherClause->orderBy('test'));
    }

    /**
     * @expectedException \Mason\Exception
     */
    public function testCallNonExistentParentMethod()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Query',
            array(), '', true, true, true
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($statement), '', true, true, true
        );

        $this->assertFalse($clause->doesNotExist());
    }

    public function testClose()
    {
        $statement = $this->getMockForAbstractClass(
            'Mason\Query',
            array(), '', true, true, true
        );

        $clause = $this->getMockForAbstractClass(
            'Mason\Scaffold\Clause\Where',
            array($statement), '', true, true, true
        );

        $newClause = $clause->addOr();

        $this->assertSame($statement, $clause->close());
        $this->assertSame($clause, $newClause->close());
    }
}
