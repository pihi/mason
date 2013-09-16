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

class Insert extends \Mason\Scaffold\Clause\Insert
{
    public function addTable($table) 
    {
        if (count($this->tables) > 0) {
            throw new \Mason\IllegalStateException("Cannot add more than one table");
        }

        parent::addTable($table);
    }

    public function compile($root = true)
    {
        if ($root) return $this->context->compile();
        $tbl = $this->tables[0];
        return 'INSERT INTO '.$tbl->getName();
    }

    public function __toString()
    {
        return $this->compile(false);
    }
}
