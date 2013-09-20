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

class Select extends \Mason\Scaffold\Clause\Select
{
    public function compile($root = true)
    {
        if ($root) return $this->context->compile();

        $str = '';
        if (!count($this->fields)) {
            $str.='*';
        } else {
            for ($i=0, $c=count($this->fields); $i<$c; $i++) {
                $str.= (($i > 0) ? ',' : '');
                $str.= $this->compileField($this->field[$i]);
            }
        }

        return $str;
    }

    private function compileField($field)
    {
        if (!($field instanceof \Mason\Alias))
            throw new \Mason\InvalidStateException("Invalid field parameter");

        $name = $field->getName();

        if ($name instanceof \Mason\Clause || $name instanceof \Mason\Statement) {
            $str.= '('.$name->compile().')';
        } else if ($name instanceof \Mason\Expression) {
            $str.= (string)$name;
        } else {
            if (false !== strpos($name, '.')) { 
                list($tbl,$name) = explode('.', $name);
                $str.= '`'.$tbl.'`.';
            }

            $str.= ($name == '*') ? $name : '`'.$name.'`';
        }

        if ($alias = $field->getAlias()) {
            $str.=' AS `'.$alias.'`';
        }
    }
}
