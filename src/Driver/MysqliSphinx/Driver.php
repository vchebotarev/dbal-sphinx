<?php

namespace Chebur\DBALSphinx\Driver\MysqliSphinx;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use Doctrine\DBAL\Driver\Mysqli\MysqliException;

class Driver extends AbstractMySQLDriver
{
    /**
     * @inheritdoc
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        try {
            return new Connection($params, $username, $password, $driverOptions);
        } catch (MysqliException $e) {
            throw DBALException::driverException($this, $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'mysqli_sphinx';
    }

}
