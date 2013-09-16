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

abstract class Builder implements \Mason\Builder
{
    public function from($table)
    {
        $statement = $this->getSelector();
        $statement->from($table);

        $argc = func_num_args();
        for ($i=1; $i<$argc; $i++) {
            $table = func_get_arg($i);
            $statement->from($table);
        }

        return $statement;
    }

    public function update($table)
    {
        $statement = $this->getUpdater();
        $statement->update($table);

        $argc = func_num_args();
        for ($i=1; $i<$argc; $i++) {
            $table = func_get_arg($i);
            $statement->update($table);
        }

        return $statement;
    }

    public function insert($table)
    {
        $statement = $this->getInserter();
        $statement->insert($table);
        return $statement;
    }

    public function insertInto($table)
    {
        return $this->insert($table);
    }

    abstract protected function getSelector();

    abstract protected function getUpdater();

    abstract protected function getInserter();
}
