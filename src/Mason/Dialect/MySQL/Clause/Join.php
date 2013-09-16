<?php

/**
 * Mason - Fluent SQL Query Builder for PHP
 * Copyright 2013 PIHI Media
 *
 * Licensed under the "THE BEER-WARE LICENSE" (Revision 42):
 * P. Isaac Hildebrandt wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer or coffee in return
 *
 * @author P. Isaac Hildebrandt <isaac@pihimedia.com>
 * @copyright P. Isaac Hildebrandt, 05 September, 2013
 * @package Mason
 */

namespace Mason\Dialect\MySQL\Clause;

class Join extends \Mason\Scaffold\Clause\Join
{
    protected function getWhereClause()
    {
        return new Where($this->context);
    }

    public function compile($root = true)
    {
        if ($root) return $this->context->compile();

        $str = '';
        foreach ($this->joins as $type => $joins) {
            foreach ($joins as $join) {
                if (strlen($str)) $str.= ' ';

                list ($table, $where) = $join;
                switch ($type) {
                case 'outer':
                    $str.= 'FULL OUTER JOIN ';
                    break;
                case 'left':
                    $str.= 'LEFT OUTER JOIN ';
                    break;
                case 'right':
                    $str.= 'RIGHT OUTER JOIN ';
                    break;
                case 'inner': default:
                    $str.= 'INNER JOIN ';
                    break;
                }

                $str.= '`'.$table->getName().'` ';
                if ($alias = $table->getAlias()) {
                    $str.= 'AS `'.$alias.'` ';
                }
                $str.= 'ON '.$where->compile(false);
            }
        }

        return $str;
    }
}
