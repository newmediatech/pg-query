<?php

namespace Misantron\QueryBuilder\Query\Condition;

use Misantron\QueryBuilder\Assert\Assert;

/**
 * Class ArrayContainsCondition.
 */
class ArrayContainsCondition extends Condition
{
    /**
     * @var string
     */
    private $values;

    /**
     * @param string $column
     * @param array  $values
     */
    public function __construct(string $column, array $values)
    {
        parent::__construct($column);

        Assert::valuesNotEmpty($values);

        $this->values = $this->escapeArray($values);
    }

    /**
     * @param string $column
     * @param array  $values
     *
     * @return ArrayContainsCondition
     */
    public static function create(string $column, array $values)
    {
        return new static($column, $values);
    }

    /**
     * @return array
     */
    protected function getAcceptableOperators(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s @> %s', $this->column, $this->values);
    }
}
