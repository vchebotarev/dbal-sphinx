<?php

namespace Chebur\DBALSphinx\Driver\PDOSphinx;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;
use PDOException;

class Driver extends PDOMySqlDriver
{
    /**
     * @inheritdoc
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        try {
            $conn = new Connection($this->constructPdoDsn($params), $username, $password, $driverOptions);
        } catch (PDOException $e) {
            throw DBALException::driverException($this, $e);
        }

        return $conn;
    }

    /**
     * @inheritDoc
     */
    protected function constructPdoDsn(array $params)
    {
        unset($params['dbname']);

        return parent::constructPdoDsn($params);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'pdo_sphinx';
    }

}