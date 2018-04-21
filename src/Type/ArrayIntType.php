<?php

namespace Chebur\DBALSphinx\Type;

use Chebur\DBALSphinx\Platforms\SphinxPlatform;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * @todo multi64
 */
class ArrayIntType extends Type
{
    const ARRAY_INT = 'array_int';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::ARRAY_INT;
    }

    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        if (!$platform instanceof SphinxPlatform) {
            throw DBALException::notSupported(__METHOD__);
        }

        return 'MVA';
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        /** @var array $sqlExpr */
        return '(' . implode(',', $sqlExpr) . ')';
    }

    /**
     * @inheritDoc
     */
    public function convertToPHPValueSQL($sqlExpr, $platform)
    {
        return explode(',', $sqlExpr);
    }

}
