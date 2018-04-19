<?php

namespace Chebur\DBALSphinx\Platforms;

use Chebur\DBALSphinx\Platforms\Keywords\SphinxKeywords;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySqlPlatform;

class SphinxPlatform extends MySqlPlatform
{
    /**
     * {@inheritDoc}
     */
    protected function getReservedKeywordsClass()
    {
        return SphinxKeywords::class;
    }

    /**
     * @inheritDoc
     */
    public function supportsSavepoints()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getGuidExpression()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    //todo остальные методы


    //todo а нужен ли вообще этот класc - НУЖЕН чтобы была полная совместимость

}
