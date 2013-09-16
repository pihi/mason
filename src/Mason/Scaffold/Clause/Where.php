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

namespace Mason\Scaffold\Clause;

abstract class Where extends \Mason\Scaffold\Clause implements \Mason\Clause\Where
{
    private $parent;

    protected $mode;

    protected $conditions = array();

    public function __construct(\Mason\Statement $statement, $parent = null, $mode = 'AND')
    {
        $this->context = $statement;
        $this->parent = $parent ?: $statement;
        $this->mode = $mode;
    }

    public function addAnd()
    {
        $condition = new $this($this->context, $this);
        $this->conditions[] = $condition;
        return $condition;
    }

    public function addOr()
    {
        $condition = new $this($this->context, $this, 'OR');
        $this->conditions[] = $condition;
        return $condition;
    }

    public function __call($method, $args)
    {
        $addMethod = 'add'.ucfirst($method);
        if (method_exists($this, $addMethod)) {
            return call_user_func_array(array($this, $addMethod), $args);
        }

        $parent = $this->parent;
        do {
            //$callable = array($parent, $method);
            if (method_exists($parent, $method)) {
                return call_user_func_array(array($parent,$method), $args);
            }

            if (!property_exists($parent,'parent')) break;
            $parent = $parent->parent;
        } while (true);

        throw new \Mason\Exception('Call to undefined method '.__CLASS__.'::'.$method.'()');
    }

    /**
     * Closes a where query.
     * @return mixed
     */
    public function close()
    {
        return $this->parent;
    }
}
