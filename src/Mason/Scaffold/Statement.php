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

abstract class Statement implements \Mason\Statement
{
    protected static $aliasSeparator = ' ';

    private $tables = array();

    private $fields = array();

    private function getTable($table, $alias = null)
    {
        for ($i=0, $c=count($this->tables); $i<$c; $i++) {
            $tbl = $this->tables[$i];

            if (0 === strcasecmp($table, $tbl->getAlias())) { 
                return $tbl;
            }
        }

        for ($i=0, $c=count($this->tables); $i<$c; $i++) {
            $tbl = $this->tables[$i];

            if (0 === strcasecmp($alias, $tbl->getAlias())) {
                if (0 !== strcasecmp($table, $tbl->getName())) { 
                    throw new \Mason\InvalidStateException("Table alias '$alias' already exists");
                }

                return $tbl;
            }
        }

        return false;
    }

    private function getField($field, $alias = null)
    {
        if ($alias) {
            for ($i=0, $c=count($this->fields); $i<$c; $i++) {
                $fld = $this->fields[$i];

                if (0 === strcasecmp($alias, $fld->getAlias())) {
                    return $fld;
                }
            }
        }

        for ($i=0, $c=count($this->fields); $i<$c; $i++) {
            $fld = $this->fields[$i];

            if (0 === strcasecmp($field, $fld->getAlias())) { 
                return $fld;
            }
        }

        return false;
    }

    public function table($table, $alias = null)
    {
        if (is_object($table)) { 
            $tbl = new \Mason\Alias($table, $alias);
            $this->tables[] = $tbl;
        } else { 
            if (false !== strpos($table, static::$aliasSeparator)) { 
                list($table, $alias) = explode(static::$aliasSeparator, $table);
            }

            if (!($tbl = $this->getTable($table, $alias))) {
                $tbl = new \Mason\Alias($table, $alias);
                $this->tables[] = $tbl;
            }
        }

        return $tbl;
    }

    public function field($field, $alias = null)
    {
        if (func_num_args() > 2) { 
            $table = func_get_arg(0);
            $field = func_get_arg(1);
            $alias = func_get_arg(2);

            if (!($table instanceof \Mason\Alias)) {
                $table = $this->table($table);
            }

            $field = ($table->getAlias()?:$table->getName()).'.'.$field;
        }

        if (is_object($field)) { 
            $fld = new \Mason\Alias($field, $alias);
            $this->fields[] = $fld;
        } else { 
            if (false !== strpos($field, static::$aliasSeparator)) {
                list($field, $alias) = explode(static::$aliasSeparator, $field);
            }

            if (!($fld = $this->getField($field, $alias))) {
                $fld = new \Mason\Alias($field, $alias);
                $this->fields[] = $fld;
            }
        }

        return $fld;
    }
}
