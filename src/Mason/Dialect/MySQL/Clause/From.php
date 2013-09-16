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

class From extends \Mason\Scaffold\Clause\From
{
    protected function canUseSubquery()
    {
        return true;
    }

    public function compile($root = true)
    {
        if ($root) return $this->context->compile();

        if (!count($this->tables)) {
            throw new \Mason\InvalidStateException('No tables have been added');
        }

        $str = '';
        for ($i=0, $c = count($this->tables); $i<$c; $i++) {
            $sep = ($i > 0) ? ',' : '';

            $name = $this->tables[$i]->getName();
            $alias = $this->tables[$i]->getAlias();

            if ($name instanceof \Mason\Statement || $name instanceof \Mason\Clause) {
                $str.= $sep.'('.$name->compile().')';
            } else {
                $str .= $sep.'`'.$name.'`';
            }

            if ($alias) {
                $str .= ' AS `'.$alias.'`';
            }
        }

        return $str;
    }

    public function __toString()
    {
        return $this->compile(false);
    }
}
