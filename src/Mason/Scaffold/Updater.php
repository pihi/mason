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

abstract class Updater extends Statement implements \Mason\Updater
{
    public function update($table)
    {
    }

    public function set($field, $value = null)
    {
    }

    public function where($field, $value = null, $comparitor = null)
    {
    }

    public function orderBy($field, $direction = null)
    {
    }

    public function limit($rows, $offset = null)
    {
    }
}
