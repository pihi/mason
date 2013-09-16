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

interface Query extends Statement
{
    /**
     * Create a \Mason\Clause\Where for the current query.
     * @params mixed $field Field name as either a string or a \Mason\Field
     *  object, will also accept a \Mason\Clause\Where object
     * @params mixed $value optional Required if $field is a string or 
     *  \Mason\Field
     * @params mixed $comparitor optional String or \Mason\Comparitor
     * @return \Mason\Query
     */
    public function where($field, $value = null, $comparitor = null);

    /**
     * Create a \Mason\Clause\OrderBy for the current query.
     * @param mixed $field Field name as either a string or a \Mason\Field
     * @param string $direction optional
     * @return \Mason\Query
     */
    public function orderBy($field, $direction = null);

    /**
     * Create a \Mason\Clause\Limit for the current query.
     * @param integer $rows 
     * @param integer $offset optional
     * @return \Mason\Query
     */
    public function limit($rows, $offset = null);
}

