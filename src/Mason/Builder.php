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

interface Builder
{
    /**
     * Create a Selector for a given table or list of tables.
     * @param mixed $table String or \Mason\Table to select from, also accepts
     *  a \Mason\Builder to create a subquery if supported by the dialect
     * @param mixed $table,... unlimited OPTIONAL
     * @return \Mason\Selector
     */
    public function from($table);

    /**
     * Create an Updater for a given table or list of tables.
     * @param mixed $table String or \Mason\Table to select from
     * @param mixed $table,... unlimited OPTIONAL
     * @return \Mason\Updater
     */
    public function update($table);

    /**
     * Create an Inserter for a given table
     * @param mixed $table String or \Mason\Table to insert into
     * @return \Mason\Inserter
     */
    public function insert($table);

    /**
     * Alias for insert()
     * @param mixed $table String or \Mason\Table to insert into
     * @return \Mason\Inserter
     */
    public function insertInto($table);
}
