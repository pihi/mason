<?php

namespace Mason\Scaffold;

class StatementTest extends \PHPUnit_Framework_TestCase
{
    public function testTable()
    {
        $stm = $this->getMockForAbstractClass('Mason\\Scaffold\\Statement');

        $table = $stm->table('table', 't');
        $this->assertInstanceOf('Mason\\Alias', $table);
        $this->assertEquals('table', $table->getName());
        $this->assertEquals('t', $table->getAlias());

        $table = $stm->table('table2 t2');
        $this->assertInstanceOf('Mason\\Alias', $table);
        $this->assertEquals('table2', $table->getName());
        $this->assertEquals('t2', $table->getAlias());

        $obj = new \stdClass;
        $table = $stm->table($obj, 'a');
        $this->assertInstanceOf('Mason\\Alias', $table);
        $this->assertSame($obj, $table->getName());
        $this->assertEquals('a', $table->getAlias());

    }

    public function testGetSameTable()
    {
        $stm = $this->getMockForAbstractClass('Mason\\Scaffold\\Statement');

        $t1 = $stm->table('table', 't');
        $t2 = $stm->table('table', 't');
        $this->assertSame($t1, $t2);

        $t1 = $stm->table('table', 't');
        $t2 = $stm->table('t');
        $this->assertSame($t1, $t2);
    }

    /**
     * @expectedException \Mason\InvalidStateException
     */
    public function testGetDifferentTableWithSameAlias()
    {
        $stm = $this->getMockForAbstractClass('Mason\\Scaffold\\Statement');

        $t1 = $stm->table('table', 't');
        $t2 = $stm->table('table2', 't');
    }

    public function testField()
    {
        $stm = $this->getMockForAbstractClass('Mason\\Scaffold\\Statement');

        $field = $stm->field('test', 't');
        $this->assertInstanceOf('Mason\\Alias', $field);
        $this->assertEquals('test', $field->getName());
        $this->assertEquals('t', $field->getAlias());

        $field = $stm->field('test2 t2');
        $this->assertInstanceOf('Mason\\Alias', $field);
        $this->assertEquals('test2', $field->getName());
        $this->assertEquals('t2', $field->getAlias());

        $obj = new \stdClass;
        $field = $stm->field($obj, 'a');
        $this->assertInstanceOf('Mason\\Alias', $field);
        $this->assertSame($obj, $field->getName());
        $this->assertEquals('a', $field->getAlias());
    }

    public function testGetSameField()
    {
        $stm = $this->getMockForAbstractClass('Mason\\Scaffold\\Statement');

        $f1 = $stm->field('test', 't');
        $f2 = $stm->field('test', 't');
        $this->assertSame($f1, $f2);

        $f1 = $stm->field('test', 't');
        $f2 = $stm->field('t');
        $this->assertSame($f1, $f2);
    }

    public function testGetFieldWithTable()
    {
        $stm = $this->getMockForAbstractClass('Mason\\Scaffold\\Statement');

        $table = $stm->table('table', 't');
        $field = $stm->field($table, 'test', 't');
        $this->assertEquals('t.test', $field->getName());
        $this->assertEquals('t', $field->getAlias());

        $table = $stm->table('table2');
        $field = $stm->field($table, 'test2', 't2');
        $this->assertEquals('table2.test2', $field->getName());
        $this->assertEquals('t2', $field->getAlias());

        $table = $stm->table('table3', 't3');
        $field = $stm->field('t3', 'test3', 't3');
        $this->assertEquals('t3.test3', $field->getName());
        $this->assertEquals('t3', $field->getAlias());
    }
}
