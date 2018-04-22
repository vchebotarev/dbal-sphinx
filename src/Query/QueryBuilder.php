<?php

namespace Chebur\DBALSphinx\Query;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Query\QueryBuilder as DoctrineQueryBuilder;

class QueryBuilder extends DoctrineQueryBuilder
{
    /**
     * @inheritDoc
     */
    public function join($fromAlias, $join, $alias, $condition = null)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function innerJoin($fromAlias, $join, $alias, $condition = null)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function leftJoin($fromAlias, $join, $alias, $condition = null)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function rightJoin($fromAlias, $join, $alias, $condition = null)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function orWhere($where)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    //todo groupNby

    //todo option

    /**
     * @inheritDoc
     */
    public function orHaving($having)
    {
        throw DBALException::notSupported(__METHOD__);
    }

}
