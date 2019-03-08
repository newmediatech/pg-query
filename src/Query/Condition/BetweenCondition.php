<?php

namespace Misantron\QueryBuilder\Query\Condition;

use Misantron\QueryBuilder\Assert\Assert;

/**
 * Class BetweenCondition.
 */
class BetweenCondition extends Condition
{
    /**
     * @var array
     */
    private $values;

    /**
     * @param string $column
     * @param array  $values
     */
    public function __construct(string $column, array $values)
    {
        parent::__construct($column);

        $this->values = array_map(function ($value) {
            return $this->escapeValue($value);
        }, $values);

        Assert::numberOfElements($this->values, 2);
    }

    /**
     * @param string $column
     * @param array  $values
     *
     * @return BetweenCondition
     */
    public static function create(string $column, array $values): BetweenCondition
    {
        return new static($column, $values);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAcceptableOperators(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        $values = $this->values;
        list($rangeBegin, $rangeEnd) = $values;

        return sprintf('%s BETWEEN %s AND %s', $this->column, $rangeBegin, $rangeEnd);
    }
}
