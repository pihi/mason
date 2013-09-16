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

class Masonry
{
    /**
     * Accepts a viariable number of parameters that will be passed
     * into the dialect's clause.
     * @param string $expression
     * @param mixed optional $arg, ... unlimited
     */
    public static function expression($expression)
    {
        $args = func_get_args();
        return new static($expression, null, true);
    }

    /**
     * Check dialect implementation of any available expressions for 
     * available arguments
     */
    public static function __callStatic($method, $args)
    {
        return new static($method, $args);
    }

    private $expression;

    private $arguments;

    private $plain;

    private function __construct($expression, $arguments, $plain = false)
    {
        $this->expression = $expression;
        $this->arguments = $arguments;
        $this->plain = $plain;
    }

    public function getExpression()
    {
        return $this->expression;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function isPlain()
    {
        return $this->plain;
    }
}
