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

interface Statement extends Identity
{
    /**
     * Compiles current statement
     * @return boolean
     */
    public function compile();

    /**
     * @param $table string
     * @param optional $alias string
     * @return \Mason\Table
     */
    public function table($table, $alias = null);

    /**
     * @param optional mixed $table String or \Mason\Alias
     * @param $field string
     * @param optional $alias string
     * @return \Mason\Field
     */
    public function field($field, $alias = null);

    /**
     *
     */
    public function construct(Masonry $masonry);

    /**
     * Return the current statement as a string
     * @return string
     */
    public function __toString();
}
