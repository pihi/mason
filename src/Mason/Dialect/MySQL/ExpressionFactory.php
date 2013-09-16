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

namespace Mason\Dialect\MySQL;

class ExpressionFactory
{
    public static function construct(\Mason\Statement $statement, \Mason\Masonry $masonry) 
    {
        $expression = $masonry->getExpression();
        $arguments = $masonry->getArguments();
        array_unshift($arguments, $statement);

        if ($masonry->isPlain()) {
            return new Expression($statement, $expression);
        } else {
            $class = __NAMESPACE__.'\Expression\\'.$expression;
            if (!class_exists($class))
                throw new \Mason\InvalidStateException('Cannot create expression '.$expression);

            $refl = new \ReflectionClass($class);
            $expression = $refl->newInstanceArgs($arguments);
        }

        return $expression;
    }
}
