<?php

namespace Chebur\DBALSphinx;

use Chebur\DBALSphinx\Query\Expression\ExpressionBuilder;
use Chebur\DBALSphinx\Query\QueryBuilder;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection as DoctrineConnection;
use Doctrine\DBAL\Driver;

class Connection extends DoctrineConnection
{
    /**
     * @inheritDoc
     */
    public function __construct(array $params, Driver $driver, ?Configuration $config = null, ?EventManager $eventManager = null)
    {
        parent::__construct($params, $driver, $config, $eventManager);

        $this->_expr = new ExpressionBuilder($this);
    }

    /**
     * @inheritDoc
     */
    public function createQueryBuilder()
    {
        return new QueryBuilder($this);
    }

}
