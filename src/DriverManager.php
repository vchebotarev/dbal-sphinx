<?php

namespace Chebur\DBALSphinx;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager as DoctrineDriverManager;

class DriverManager
{
    /**
     * @var array
     */
    protected static $driverMap = [
        'pdo_sphinx'    => \Chebur\DBALSphinx\Driver\PDOSphinx\Driver::class,
        'mysqli_sphinx' => \Chebur\DBALSphinx\Driver\MysqliSphinx\Driver::class,
    ];

    /**
     * @inheritdoc
     * @see \Doctrine\DBAL\DriverManager::getConnection
     */
    public static function getConnection(array $params, Configuration $config = null, EventManager $eventManager = null)
    {
        if (!isset($params['driverClass'])) {
            if (!isset($params['driver'])) {
                throw DBALException::driverRequired();
            } elseif (!isset(self::$driverMap[$params['driver']])) {
                throw DBALException::unknownDriver($params['driver'], array_keys(self::$driverMap));
            }
            $params['driverClass'] = self::$driverMap[$params['driver']];
        }

        if (!isset($params['wrapperClass'])) {
            $params['wrapperClass'] = Connection::class;
        }

        return DoctrineDriverManager::getConnection($params, $config, $eventManager);
    }

}
