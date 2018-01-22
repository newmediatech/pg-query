<?php

namespace MediaTech\Query\Query\Mixin\Condition;


use MediaTech\Query\Helper\Escape;
use MediaTech\Query\Stringable;

/**
 * Class Condition
 * @package MediaTech\Query\Query\Mixin\Condition
 */
abstract class Condition implements Stringable
{
    use Escape;

    /**
     * @var string
     */
    protected $column;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @param string $column
     * @param string $operator
     */
    public function __construct(string $column, string $operator = '')
    {
        if (!empty($operator) && !in_array($operator, $this->getAcceptableOperators())) {
            throw new \InvalidArgumentException('Invalid condition operator');
        }

        $this->column = $this->escapeIdentifier($column, false);
        $this->operator = $operator;
    }

    /**
     * @return array
     */
    abstract protected function getAcceptableOperators(): array;
}