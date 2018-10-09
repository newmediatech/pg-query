<?php

namespace Misantron\QueryBuilder\Query\Mixin;

use Misantron\QueryBuilder\Query\Filter\Filter;
use Misantron\QueryBuilder\Query\Filter\FilterGroup;
use Misantron\QueryBuilder\Query\Mixin\Filter\ArrayCompare;
use Misantron\QueryBuilder\Query\Mixin\Filter\NullCompare;
use Misantron\QueryBuilder\Query\Mixin\Filter\RangeCompare;
use Misantron\QueryBuilder\Query\Mixin\Filter\ValueCompare;

/**
 * Trait Filters
 * @package Misantron\QueryBuilder\Query\Mixin
 */
trait Filters
{
    use ValueCompare, NullCompare, RangeCompare, ArrayCompare;

    /**
     * @var FilterGroup
     */
    private $filters;

    /**
     * @return Filterable
     */
    public function beginGroup()
    {
        return $this->andGroup();
    }

    /**
     * @return Filterable
     */
    public function andGroup()
    {
        $this->filters->append(Filter::create('(', 'AND', true));

        return $this;
    }

    /**
     * @return Filterable
     */
    public function orGroup()
    {
        $this->filters->append(Filter::create('(', 'OR', true));

        return $this;
    }

    /**
     * @return Filterable
     */
    public function endGroup()
    {
        $this->filters->append(Filter::create(')'));

        return $this;
    }

    /**
     * @return string
     */
    private function buildFilters(): string
    {
        return $this->filters->notEmpty() ? ' WHERE ' . (string)$this->filters : '';
    }
}