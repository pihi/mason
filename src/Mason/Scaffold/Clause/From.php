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

abstract class From extends \Mason\Scaffold\Clause implements \Mason\Clause\From
{
    protected $tables = array();

    public function addTable($table, $alias = null)
    {
        if (is_array($table)) {
            $tmp = $table;
            $table = $tmp[0];
            $alias = $tmp[1];
        }

        if ($table instanceof \Mason\Statement) {
            // check if a subquery is valid here
            if (!$this->canUseSubquery())
                throw new \Mason\InvalidStateException("Cannot Use Subquery in this context");

            // subqueries require an alias
            if (!$alias) 
                throw new \Mason\InvalidStateException("Subqueries require an alias");

            // cannot have itself as a subquery
            if ($table === $this->context)
                throw new \Mason\InvalidStateException("Illegal use of recursion");

            $table = new \Mason\Alias($table, $alias);
        } else if (!($table instanceof \Mason\Alias)) {
            $table = $this->context->table((string)$table, (string)$alias);
        }

        $this->tables[] = $table;
    }

    abstract protected function canUseSubquery();
}
