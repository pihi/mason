<?php

namespace Mason\Dialect\MySQL\Clause;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideTestCompile
     */
    public function testCompile($fields, $expected)
    {
        $stm = $this->getMock('Mason\Dialect\MySQL\Selector', array('field', 'construct'));

        $clause = new Select($stm);
        $refl = new \ReflectionClass($clause);
        $prop = $refl->getProperty('fields');
        $prop->setAccessible(true);
        $prop->setValue($clause, $fields);

        $select = $clause->compile(false);
        $this->assertEquals($expected, $select);
    }

    public function provideTestCompile()
    {
        $a_star = $this->getMockBuilder('Mason\Alias')->disableOriginalConstructor()->getMock();
        $a_star->expects($this->any())->method('getName')->will($this->returnValue('*'));
        $a_star->expects($this->any())->method('getAlias')->will($this->returnValue(null));

        $a_tdotstar = $this->getMockBuilder('Mason\Alias')->disableOriginalConstructor()->getMock();
        $a_tdotstar->expects($this->any())->method('getName')->will($this->returnValue('t.*'));
        $a_tdotstar->expects($this->any())->method('getAlias')->will($this->returnValue(null));

        $a_tdottest1 = $this->getMockBuilder('Mason\Alias')->disableOriginalConstructor()->getMock();
        $a_tdottest1->expects($this->any())->method('getName')->will($this->returnValue('t.test1'));
        $a_tdottest1->expects($this->any())->method('getAlias')->will($this->returnValue('test1alias'));

        $a_tdottest2 = $this->getMockBuilder('Mason\Alias')->disableOriginalConstructor()->getMock();
        $a_tdottest2->expects($this->any())->method('getName')->will($this->returnValue('t.test2'));
        $a_tdottest2->expects($this->any())->method('getAlias')->will($this->returnValue('test2alias'));

        return array(
            array(
                array($a_star),
                '*'
            ),
            array(
                array($a_tdotstar),
                '`t`.*'
            ),
            array(
                array($a_tdottest1, $a_tdottest2),
                '`t`.`test1` AS `test1alias`,`t`.`test2` AS `test2alias`'
            ),
            array(
                array($a_tdotstar, $a_tdottest1),
                '`t`.*,`t`.`test1` AS `test1alias`'
            )
        );
    }
}
