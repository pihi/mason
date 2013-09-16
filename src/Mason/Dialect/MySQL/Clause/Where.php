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

use Mason\Dialect\MySQL;

class Where extends \Mason\Scaffold\Clause\Where
{
    public function addCondition($field, $value = null, $comparitor = null)
    {
        $str = '';

        if ($field instanceof \Mason\Masonry) { 
            $field = $this->context->construct($field);
            $str.=(string)$field;
        } else {
            if (!($field instanceof \Mason\Alias)) {
                $field = $this->context->field($field);
            }

            $name = $field->getName();
            $alias = $field->getAlias();

            $str.='`'.str_replace('.','`.`',($alias?:$name)).'`';
        }

        if (null === $comparitor) {
            $comparitor = '=';
        }

        if ($value instanceof \Mason\Clause || $value instanceof \Mason\Statement) {
            if ($comparitor == '=') {
                $comparitor = 'IN';
            } else {
                $comparitor = 'NOT IN';
            }

            $value = '('.$value->compile().')';
        } else if (is_array($value)) {
            if ($comparitor == '=') { 
                $comparitor = 'IN';
            } else {
                $comparitor = 'NOT IN';
            }

            $value = '(\''.implode('\',\'',$value).'\')';
        } else if ($value instanceof \Mason\Alias) { 
            $value = '`'.str_replace('.','`.`',$value->getName()).'`';
        } else if ($value instanceof \Mason\Masonry) {
            // inflate the masonry object and re-add the condition
            $value = $this->context->construct($value);
            return $this->addCondition($field, $value, $comparitor);
        } else if ($value instanceof MySQL\Expression\Null) {
            if ($comparitor == '=') {
                $comparitor = 'IS';
            } else { 
                $comparitor = 'IS NOT';
            }
        }

        $value = (string)$value;

        $str.=' '.$comparitor.' '.$value;
        $this->conditions[] = $str;
        return $this;
    }

    public function compile($root = true)
    {
        if ($root) return $this->context->compile();

        $str = '';

        for ($i=0,$c=count($this->conditions); $i<$c; $i++) {
            $mode = ($i > 0) ? ' '.$this->mode.' ' : '';
            $condition = $this->conditions[$i];
            $str .= $mode.'('.$condition.')';
        }

        return $str;
    }

    public function __toString()
    {
        return $this->compile(false);
    }
}

