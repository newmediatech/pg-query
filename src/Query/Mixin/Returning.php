<?php

declare(strict_types=1);

namespace Misantron\QueryBuilder\Query\Mixin;

use Misantron\QueryBuilder\Assert\QueryAssert;

/**
 * Trait Returning.
 *
 * @method array parseList($items)
 */
trait Returning
{
    /**
     * @var array
     */
    private $returning = [];

    /**
     * @param string|array $items
     *
     * @return $this
     */
    public function returning($items): self
    {
        QueryAssert::columnsNotEmpty($items);

        $this->returning = $this->parseList($items);

        return $this;
    }

    private function buildReturning(): string
    {
        return !empty($this->returning) ? ' RETURNING ' . implode(',', $this->returning) : '';
    }
}
