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

namespace Mason;

interface Selector extends Query
{
    /**
     * Create a \Mason\Clause\Select for the current query.
     * @param mixed $field String or \Mason\Field
     * @param mixed $field,... unlimited optional
     * @return \Mason\Selector
     */
    public function select($field);

    /**
     * Create a \Mason\Clause\From for the current query.
     * @param mixed $table String or \Mason\Table
     * @return \Mason\Selector
     */
    public function from($table);

    /**
     * Create a \Mason\Clause\Join for the current query.
     * @param mixed $table String or \Mason\Table
     * @param mixed $on String, \Mason\Field, or \Mason\Clause\Where
     * @param mixed $field Required if $on is a String or \Mason\Field
     * @param mixed $comparitor optional
     * @return \Mason\Selector
     */
    public function join($table, $on, $field = null, $comparitor = null);

    /**
     * Create a \Mason\Clause\InnerJoin for the current query.
     * @param mixed $table String or \Mason\Table
     * @param mixed $on String, \Mason\Field, or \Mason\Clause\Where
     * @param mixed $field Required if $on is a String or \Mason\Field
     * @param mixed $comparitor optional
     * @return \Mason\Selector
     */
    public function inner($table, $on, $field = null, $comparitor = null);

    /**
     * Create a \Mason\Clause\OuterJoin for the current query.
     * @param mixed $table String or \Mason\Table
     * @param mixed $on String, \Mason\Field, or \Mason\Clause\Where
     * @param mixed $field Required if $on is a String or \Mason\Field
     * @param mixed $comparitor optional
     * @return \Mason\Selector
     */
    public function outer($table, $on, $field = null, $comparitor = null);

    /**
     * Create a \Mason\Clause\LeftJoin for the current query.
     * @param mixed $table String or \Mason\Table
     * @param mixed $on String, \Mason\Field, or \Mason\Clause\Where
     * @param mixed $field Required if $on is a String or \Mason\Field
     * @param mixed $comparitor optional
     * @return \Mason\Selector
     */
    public function left($table, $on, $field = null, $comparitor = null);

    /**
     * Create a \Mason\Clause\RightJoin for the current query.
     * @param mixed $table String or \Mason\Table
     * @param mixed $on String, \Mason\Field, or \Mason\Clause\Where
     * @param mixed $field Required if $on is a String or \Mason\Field
     * @param mixed $comparitor optional
     * @return \Mason\Selector
     */
    public function right($table, $on, $field = null, $comparitor = null);

    /**
     * Create a \Mason\Clause\GroupBy for the current query.
     * @param mixed $field String or \Mason\Table
     */
    public function groupBy($field);

    /**
     * Create a \Mason\Clause\Having for the current query.
     * @param mixed $field String, \Mason\Field, or \Mason\Expression
     * @param mixed $value optional
     * @param mixed $comparitor optional
     */
    public function having($field, $value = null, $comparitor = null);
}

