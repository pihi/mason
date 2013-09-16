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

class Selector extends \Mason\Scaffold\Selector
{
    private static $currentInstanceId = 0;

    /**
     * @var integer
     */
    private $instanceId;

    /**
     * @var \Mason\Clause\From
     */
    private $from;

    /**
     * @var \Mason\Clause\Select
     */
    private $select;

    /**
     * @var \Mason\Clause\Join
     */
    private $join;

    /**
     * @var \Mason\Clause\Where
     */
    private $where;

    /**
     * @var \Mason\Clause\GroupBy
     */
    private $groupBy;

    /**
     * @var \Mason\Clause\Having
     */
    private $having;

    /**
     * @var \Mason\Clause\OrderBy
     */
    private $orderBy;

    /**
     * @var \Mason\Clause\Limit
     */
    private $limit;

    public function __construct(
        Clause\Select $select = null,
        Clause\From $from = null,
        Clause\Join $join = null,
        Clause\Where $where = null,
        Clause\GroupBy $groupBy = null,
        Clause\Having $having = null,
        Clause\OrderBy $orderBy = null,
        Clause\Limit $limit = null)
    {
        static::$currentInstanceId++;
        $this->instanceId = static::$currentInstanceId;

        $this->select = $select;
        $this->from = $from;
        $this->join = $join;
        $this->where = $where;
        $this->groupBy = $groupBy;
        $this->having = $having;
        $this->orderBy = $orderBy;
        $this->limit = $limit;
    }

    protected function getFromClause()
    {
        if (!$this->from) {
            $this->from = new Clause\From($this);
        }

        return $this->from;
    }

    protected function getSelectClause()
    {
        if (null === $this->select) {
            $this->select = new Clause\Select($this);
        }

        return $this->select;
    }

    protected function getJoinClause()
    {
        if (null === $this->join) {
            $this->join = new Clause\Join($this);
        }

        return $this->join;
    }

    protected function getWhereClause()
    {
        if (null === $this->where) {
            $this->where = new Clause\Where($this);
        }

        return $this->where;
    }

    protected function getGroupByClause()
    {
        if (null === $this->groupBy) {
            $this->groupBy = new Clause\GroupBy($this);
        }

        return $this->groupBy;
    }

    protected function getHavingClause()
    {
        return $this->having;
    }

    protected function getOrderByClause()
    {
        if (null === $this->orderBy) {
            $this->orderBy = new Clause\OrderBy($this);
        }

        return $this->orderBy;
    }

    protected function getLimitClause()
    {
        if (null === $this->limit) {
            $this->limit = new Clause\Limit($this);
        }

        return $this->limit;
    }

    public function getInstanceId()
    {
        return $this->instanceId;
    }

    public function compile()
    {
        $this->query = '';
        $this->query.='SELECT '.$this->getSelectClause();
        if ($this->from) $this->query.=' FROM '.$this->from;
        if ($this->join) $this->query.=' '.$this->join;
        if ($this->where) $this->query.=' WHERE '.$this->where;
        if ($this->groupBy) $this->query.=' GROUP BY '.$this->groupBy;
        if ($this->having) $this->query.=' HAVING '.$this->having;
        if ($this->orderBy) $this->query.=' ORDER BY '.$this->orderBy;
        if ($this->limit) $this->query.=' LIMIT '.$this->limit;
        return $this->query;
    }

    public function construct(\Mason\Masonry $masonry)
    {
        return ExpressionFactory::construct($this, $masonry);
    }

    public function __toString()
    {
        $this->compile();
        return $this->query;
    }
}
