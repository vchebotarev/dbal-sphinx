<?php

namespace Chebur\DBALSphinx\Driver;

use Chebur\DBALSphinx\Platforms\SphinxPlatform;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\AbstractMySQLDriver;

abstract class AbstractSphinxDriver extends AbstractMySQLDriver
{
    /**
     * @inheritDoc
     */
    public function getDatabasePlatform()
    {
        return new SphinxPlatform();
    }

    /**
     * @inheritDoc
     */
    public function createDatabasePlatformForVersion($version)
    {
        return $this->getDatabasePlatform();
    }

    /**
     * @inheritDoc
     */
    public function getDatabase(Connection $conn)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getSchemaManager(Connection $conn)
    {
        throw DBALException::notSupported(__METHOD__);
    }

}
