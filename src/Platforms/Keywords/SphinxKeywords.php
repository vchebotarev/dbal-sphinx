<?php

namespace Chebur\DBALSphinx\Platforms\Keywords;

use Doctrine\DBAL\Platforms\Keywords\KeywordList;

class SphinxKeywords extends KeywordList
{
    /**
     * http://sphinxsearch.com/docs/current.html#sphinxql-reserved-keywords
     * @inheritDoc
     */
    protected function getKeywords()
    {
        return [
            'AND',
            'AS',
            'BY',
            'DIV',
            'FACET',
            'FALSE',
            'FROM',
            'ID',
            'IN',
            'IS',
            'LIMIT',
            'MOD',
            'NOT',
            'NULL',
            'OR',
            'ORDER',
            'SELECT',
            'TRUE',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'Sphinx';
    }

}
