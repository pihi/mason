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

namespace Mason\Scaffold\Clause;

abstract class Join extends \Mason\Scaffold\Clause implements \Mason\Clause\Join
{
    protected $joins = array();

    public function addJoin($type, $table, $on, $field = null, $comparitor = null)
    {
        if (!($table instanceof \Mason\Alias)) { 
            $table = $this->context->table($table);
        }

        $on = $this->prepareJoin($on, $field, $comparitor);

        $type = (string)$type;
        if (!isset($this->joins[$type])) { 
            $this->joins[$type] = array();
        }

        $this->joins[$type][] = array($table, $on);
    }

    private function prepareJoin($on, $field = null, $comparitor = null)
    {
        if (!($on instanceof \Mason\Scaffold\Clause\Where)) {
            if (!($on instanceof \Mason\Alias)) { 
                $on = $this->context->field($on);
            }

            if (null === $field) {
                throw new \Mason\InvalidStateException("Value is required");
            }

            if (!($field instanceof \Mason\Alias)) {
                $field = $this->context->field($field);
            }

            $where = $this->getWhereClause();
            $where->addCondition($on, $field, $comparitor);
            $on = $where;
        }

        return $on;
    }

    abstract protected function getWhereClause();
}

