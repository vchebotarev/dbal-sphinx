<?php

namespace Chebur\DBALSphinx\Platforms;

use Chebur\DBALSphinx\Platforms\Keywords\SphinxKeywords;
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

    //todo

}
