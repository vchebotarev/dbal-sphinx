<?php

namespace Chebur\DBALSphinx\Driver\PDOSphinx;

use Chebur\DBALSphinx\Driver\AbstractSphinxDriver;
use Doctrine\DBAL\DBALException;
use PDOException;

class Driver extends AbstractSphinxDriver
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
     * Constructs the MySql Sphinx PDO DSN.
     * @see \Doctrine\DBAL\Driver\PDOMySql\Driver::constructPdoDsn except dbname
     *
     * @param array $params
     *
     * @return string The DSN.
     */
    protected function constructPdoDsn(array $params)
    {
        $dsn = 'mysql:';
        if (isset($params['host']) && $params['host'] != '') {
            $dsn .= 'host=' . $params['host'] . ';';
        }
        if (isset($params['port'])) {
            $dsn .= 'port=' . $params['port'] . ';';
        }
        if (isset($params['unix_socket'])) {
            $dsn .= 'unix_socket=' . $params['unix_socket'] . ';';
        }
        if (isset($params['charset'])) {
            $dsn .= 'charset=' . $params['charset'] . ';';
        }

        return $dsn;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'pdo_sphinx';
    }

}