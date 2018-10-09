<?php

namespace Misantron\QueryBuilder\Query;

use Misantron\QueryBuilder\Expression\Field;
use Misantron\QueryBuilder\Helper\Escape;
use Misantron\QueryBuilder\Stringable;

/**
 * Class Query
 * @package Misantron\QueryBuilder\Query
 */
abstract class Query implements Stringable
{
    use Escape;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @var string
     */
    protected $table;

    /**
     * @param \PDO $pdo
     * @param string $table
     */
    public function __construct(\PDO $pdo, string $table)
    {
        if (empty($table)) {
            throw new \InvalidArgumentException('Table name is empty');
        }

        $this->pdo = $pdo;
        $this->table = $this->escapeIdentifier($table);
    }

    /**
     * @return Query
     */
    public function execute()
    {
        $query = $this->__toString();

        $this->statement = $this->pdo->prepare($query);
        $this->statement->execute();

        return $this;
    }

    /**
     * @throws \RuntimeException
     */
    protected function assertQueryExecuted()
    {
        if (!$this->statement instanceof \PDOStatement) {
            throw new \RuntimeException('Data fetch error: query must be executed before fetch data');
        }
    }

    /**
     * @param array|string $items
     * @return array
     */
    protected function parseList($items): array
    {
        if (is_string($items)) {
            $items = explode(',', $items);
        }

        return array_filter(array_map(function ($item) {
            return $item instanceof Field ?
                (string)$item :
                $this->escapeIdentifier(trim($item));
        }, $items));
    }
}