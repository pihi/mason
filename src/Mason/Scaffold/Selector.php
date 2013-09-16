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

namespace Mason\Scaffold;

abstract class Selector extends Statement implements \Mason\Selector
{
    public function select($field)
    {
        $clause = $this->getSelectClause();
        $clause->addField($field);

        $argc = func_num_args();
        for ($i=1; $i<$argc; $i++) {
            $clause->addField(func_get_arg($i));
        }

        return $this;
    }

    public function from($table)
    {
        $clause = $this->getFromClause();
        $clause->addTable($table);

        $argc = func_num_args();
        for ($i=1; $i<$argc; $i++) {
            $clause->addTable(func_get_arg($i));
        }

        return $this;
    }

    public function join($table, $on, $field = null, $comparitor = null)
    {
        return $this->inner($table, $on, $field, $comparitor);
    }

    public function inner($table, $on, $field = null, $comparitor = null)
    {
        $clause = $this->getJoinClause();
        $clause->addJoin(__FUNCTION__, $table, $on, $field, $comparitor);

        return $this;
    }

    public function outer($table, $on, $field = null, $comparitor = null)
    {
        $clause = $this->getJoinClause();
        $clause->addJoin(__FUNCTION__, $table, $on, $field, $comparitor);

        return $this;
    }

    public function left($table, $on, $field = null, $comparitor = null)
    {
        $clause = $this->getJoinClause();
        $clause->addJoin(__FUNCTION__, $table, $on, $field, $comparitor);

        return $this;
    }

    public function right($table, $on, $field = null, $comparitor = null)
    {
        $clause = $this->getJoinClause();
        $clause->addJoin(__FUNCTION__, $table, $on, $field, $comparitor);

        return $this;
    }

    public function groupBy($field)
    {
        $clause = $this->getGroupByClause();
        $clause->addGroup($field);
        return $this;
    }

    public function having($field, $value = null, $comparitor = null)
    {
        return $this;
    }

    public function where($field = null, $value = null, $comparitor = null)
    {
        if ($field === null) {
            return $this->getWhereClause();
        } else {
            $clause = $this->getWhereClause();
            $clause->addCondition($field, $value, $comparitor);
        }

        return $this;
    }

    public function orderBy($field, $direction = null)
    {
        $clause = $this->getOrderByClause();
        $clause->addOrder($field, $direction);
        return $this;
    }

    public function limit($rows, $offset = null)
    {
        $clause = $this->getLimitClause();
        $clause->setLimit($rows);
        $clause->setOffset($offset);
        return $this;
    }

    abstract protected function getFromClause();

    abstract protected function getSelectClause();

    abstract protected function getJoinClause();

    abstract protected function getWhereClause();

    abstract protected function getGroupByClause();

    abstract protected function getHavingClause();

    abstract protected function getOrderByClause();

    abstract protected function getLimitClause();
}
