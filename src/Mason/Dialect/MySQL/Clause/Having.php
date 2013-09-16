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

class Having extends \Mason\Scaffold\Clause implements \Mason\Clause\Having
{
    private $having = array();

    public function addCondition($field, $value, $comparitor = null)
    {
        if (!($field instanceof \Mason\Alias)) {
            $field = $this->context->field($field);
        }

        $str = '';

        $this->having[] = $str;
    }

    public function compile($root = true)
    {
        if ($root) return $this->context->compile();

        $str = '';
        for ($i=0, $c=count($this->having); $i<$c; $i++) {
        }

        return $str;
    }
}
