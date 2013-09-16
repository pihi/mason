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

class Limit extends \Mason\Scaffold\Clause\Limit
{
    public function compile($root = true) 
    {
        if ($root) return $this->context->compile();

        $str = $this->limit;
        if ($this->offset) {
            $str.= ', OFFSET '.$this->offset;
        }

        return $str;
    }
}
