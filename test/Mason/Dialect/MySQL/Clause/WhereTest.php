<?php

namespace Mason\Dialect\MySQL\Clause;

class WhereTest extends \PHPUnit_Framework_TestCase
{
    protected function getClause($mode)
    {
        $ctx = $this->getMockForAbstractClass(
            'Mason\Scaffold\Statement',
            array(), '', true, true, true,
            array('field')
        );

        $ctx->expects($this->any())
            ->method('construct')
            ->will($this->returnValue('EXPRESSION'));

        $ctx->expects($this->any())
            ->method('field')
            ->will($this->returnCallback(function ($field) {
                $alias = null;
                if (false !== strpos($field, ' ')) {
                    list($field, $alias) = explode(' ', $field);
                }
                return new \Mason\Alias($field, $alias);
            }));

        return new Where($ctx, null, $mode);
    }

    /**
     * @dataProvider provideTestCompileConditions
     */
    public function testCompileConditions($mode, $conditions, $expected)
    {
        $clause = $this->getClause($mode);

        foreach ($conditions as $condition) {
            $actual = $clause->addCondition($condition[0], $condition[1], $condition[2]);
        }

        $this->assertSame($actual, $clause);

        $str = $clause->compile(false);
        $this->assertEquals($expected, $str);

        $str = $clause->__toString();
        $this->assertEquals($expected, $str);
    }

    public function provideTestCompileConditions()
    {
        $stmToCompile = $this->getMockForAbstractClass(
            'Mason\Statement', array(), '', true, true, true, 
            array('compile', 'construct')
        );

        $stmToCompile->expects($this->any())
            ->method('compile')
            ->will($this->returnValue('SELECT id FROM `test`'));

        $masonryToCompile = $this->getMockBuilder('Mason\Masonry')
            ->disableOriginalConstructor()
            ->getMock();

        $aliasToCompile = $this->getMockBuilder('Mason\Alias')
            ->disableOriginalConstructor()
            ->getMock();

        $aliasToCompile->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('t2.id'));

        $aliasToCompile->expects($this->any())
            ->method('getAlias')
            ->will($this->returnValue('t2id'));

        return array(
            array(
                'AND',
                array(
                    array('test', 'a', '=')
                ),
                '(`test` = a)'
            ),
            array(
                'AND',
                array(
                    array('test1', 'a', '='),
                    array('test2', 'b', '=')
                ),
                '(`test1` = a) AND (`test2` = b)'
            ),
            array(
                'AND',
                array(
                    array('test1', 'a', null)
                ),
                '(`test1` = a)'
            ),
            array(
                'OR',
                array(
                    array('t.test1', array(1,2,3,4), '='),
                    array('t.test2', array(1,2,3,4), '<>')
                ),
                '(`t`.`test1` IN (\'1\',\'2\',\'3\',\'4\')) OR (`t`.`test2` NOT IN (\'1\',\'2\',\'3\',\'4\'))'
            ),
            array(
                'AND',
                array(
                    array('test1', $this->getMockForAbstractClass('\Mason\Dialect\MySQL\Expression\Null', array(), '', false), '=')
                ),
                '(`test1` IS NULL)'
            ),
            array(
                'AND',
                array(
                    array('test1', $this->getMockForAbstractClass('\Mason\Dialect\MySQL\Expression\Null', array(), '', false), '<>')
                ),
                '(`test1` IS NOT NULL)'
            ),
            array(
                'AND',
                array(
                    array('test1', $stmToCompile, '=')
                ),
                '(`test1` IN (SELECT id FROM `test`))'
            ),
            array(
                'AND',
                array(
                    array('test1', $stmToCompile, '<>')
                ),
                '(`test1` NOT IN (SELECT id FROM `test`))'
            ),
            array(
                'AND',
                array(
                    array('test1', $masonryToCompile, '=')
                ),
                '(`test1` = EXPRESSION)'
            ),
            array(
                'AND',
                array(
                    array($masonryToCompile, 'value', '=')
                ),
                '(EXPRESSION = value)'
            ),
            array(
                'AND',
                array(
                    array('test1', $aliasToCompile, '=')
                ),
                '(`test1` = `t2`.`id`)'
            ),
        );
    }
}
