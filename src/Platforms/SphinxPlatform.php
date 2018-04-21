<?php

namespace Chebur\DBALSphinx\Platforms;

use Chebur\DBALSphinx\Platforms\Keywords\SphinxKeywords;
use Chebur\DBALSphinx\Type\ArrayIntType;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\TrimMode;
use Doctrine\DBAL\Schema\Constraint;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Identifier;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\Types\Type;

//class SphinxPlatform extends MySqlPlatform
class SphinxPlatform extends AbstractPlatform
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'sphinx';
    }

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
    public function getBooleanTypeDeclarationSQL(array $columnDef)
    {
        return 'BOOL';
    }

    /**
     * @inheritDoc
     */
    public function getIntegerTypeDeclarationSQL(array $columnDef)
    {
        //return 'INTEGER';
        return 'INT';
    }

    /**
     * @inheritDoc
     */
    public function getBigIntTypeDeclarationSQL(array $columnDef)
    {
        return 'BIGINT';
    }

    /**
     * @inheritDoc
     */
    public function getSmallIntTypeDeclarationSQL(array $columnDef)
    {
        return $this->getIntegerTypeDeclarationSQL($columnDef);
    }

    /**
     * @inheritDoc
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getClobTypeDeclarationSQL(array $field)
    {
        //$this->getVarcharTypeDeclarationSQL($field);
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getBlobTypeDeclarationSQL(array $field)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getVarcharTypeDeclarationSQL(array $field)
    {
        return $this->getVarcharTypeDeclarationSQLSnippet(0, false);
    }

    /**
     * @inheritDoc
     */
    public function getBinaryTypeDeclarationSQL(array $field)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getJsonTypeDeclarationSQL(array $field)
    {
        return 'JSON';
    }

    /**
     * @inheritDoc
     */
    protected function getVarcharTypeDeclarationSQLSnippet($length, $fixed)
    {
        return 'STRING';
    }

    /**
     * http://sphinxsearch.com/docs/current.html#conf-rt-attr-uint
     * @inheritDoc
     */
    protected function initializeDoctrineTypeMappings()
    {
        $this->doctrineTypeMapping = [
            'uint'      => Type::INTEGER,
            'bigint'    => Type::BIGINT,
            'float'     => Type::FLOAT,
            'bool'      => Type::BOOLEAN,
            'timestamp' => Type::DATETIME,
            'string'    => Type::STRING,
            'field'     => Type::STRING,
            'json'      => Type::JSON,
            'mva'       => ArrayIntType::ARRAY_INT,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIdentifierQuoteCharacter()
    {
        return '`';
    }

    /**
     * @inheritDoc
     */
    public function getSqlCommentStartString()
    {
        return '/*';
    }

    /**
     * @inheritDoc
     */
    public function getSqlCommentEndString()
    {
        return '*/';
    }

    /**
     * 4 MB
     * http://sphinxsearch.com/docs/current.html#conf-sql-attr-string
     * @inheritDoc
     */
    public function getVarcharMaxLength()
    {
        return parent::getVarcharMaxLength();
    }

    /**
     * http://sphinxsearch.com/docs/current.html#sphinxql-select
     * @inheritDoc
     */
    public function getCountExpression($column)
    {
        if ($column != '*') {
            $column = 'DISTINCT '.$column;
        }
        return parent::getCountExpression($column);
    }

    /**
     * @inheritDoc
     */
    public function getMd5Expression($column)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * Применим только к MVA и json
     * @inheritDoc
     */
    public function getLengthExpression($column)
    {
        return parent::getLengthExpression($column);
    }

    /**
     * @inheritDoc
     */
    public function getRoundExpression($column, $decimals = 0)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getModExpression($expression1, $expression2)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getTrimExpression($str, $mode = TrimMode::UNSPECIFIED, $char = false)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getRtrimExpression($str)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getLtrimExpression($str)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getUpperExpression($str)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getLowerExpression($str)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getNowExpression()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getSubstringExpression($value, $from, $length = null)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getConcatExpression()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getAcosExpression($value)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getPiExpression()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getForUpdateSQL()
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getDropDatabaseSQL($database)
    {
        DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getDropTableSQL($table)
    {
        DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getDropTemporaryTableSQL($table)
    {
        DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getDropIndexSQL($index, $table = null)
    {
        DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getDropConstraintSQL($constraint, $table)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getDropForeignKeySQL($foreignKey, $table)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCreateTableSQL(Table $table, $createFlags = self::CREATE_INDEXES)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCommentOnColumnSQL($tableName, $columnName, $comment)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCreateTemporaryTableSnippetSQL()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCreateConstraintSQL(Constraint $constraint, $table)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCreateIndexSQL(Index $index, $table)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    protected function getPartialIndexSQL(Index $index)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    protected function getCreateIndexSQLFlags(Index $index)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCreatePrimaryKeySQL(Index $index, $table)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCreateForeignKeySQL(ForeignKeyConstraint $foreignKey, $table)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * Mysql variant
     * @inheritDoc
     */
    public function getAlterTableSQL(TableDiff $diff)
    {
        $columnSql = [];
        $queryParts = [];
        foreach ($diff->addedColumns as $column) {
            if ($this->onSchemaAlterTableAddColumn($column, $diff, $columnSql)) {
                continue;
            }

            $columnArray = $column->toArray();
            $columnArray['comment'] = $this->getColumnComment($column);
            $queryParts[] = 'ADD ' . $this->getColumnDeclarationSQL($column->getQuotedName($this), $columnArray);
        }

        foreach ($diff->removedColumns as $column) {
            if ($this->onSchemaAlterTableRemoveColumn($column, $diff, $columnSql)) {
                continue;
            }

            $queryParts[] =  'DROP ' . $column->getQuotedName($this);
        }


        $sql = [];
        $tableSql = [];

        if ( ! $this->onSchemaAlterTable($diff, $tableSql)) {
            if (count($queryParts) > 0) {
                $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . implode(", ", $queryParts);
            }
        }

        return array_merge($sql, $tableSql, $columnSql);
    }

    /**
     * @inheritDoc
     */
    protected function getPreAlterTableIndexForeignKeySQL(TableDiff $diff)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    protected function getPostAlterTableIndexForeignKeySQL(TableDiff $diff)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    protected function getRenameIndexSQL($oldIndexName, Index $index, $tableName)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    protected function _getAlterTableIndexForeignKeySQL(TableDiff $diff)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getColumnDeclarationSQL($name, array $field)
    {
        if (isset($field['columnDefinition'])) {
            $columnDef = $this->getCustomTypeDeclarationSQL($field);
        } else {
            $columnDef = $field['type']->getSQLDeclaration($field, $this);
        }

        return $name . ' ' . $columnDef;
    }

    /**
     * @inheritDoc
     */
    public function getDecimalTypeDeclarationSQL(array $columnDef)
    {
        return $this->getFloatDeclarationSQL($columnDef);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultValueDeclarationSQL($field)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCheckDeclarationSQL(array $definition)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getUniqueConstraintDeclarationSQL($name, Index $index)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getIndexDeclarationSQL($name, Index $index)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getIndexFieldDeclarationListSQL(array $fields)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getTemporaryTableSQL()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getTemporaryTableName($tableName)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getForeignKeyDeclarationSQL(ForeignKeyConstraint $foreignKey)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getAdvancedForeignKeyOptionsSQL(ForeignKeyConstraint $foreignKey)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getForeignKeyReferentialActionSQL($action)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getForeignKeyBaseDeclarationSQL(ForeignKeyConstraint $foreignKey)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getUniqueFieldDeclarationSQL()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCurrentDateSQL()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getCurrentTimeSQL()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * http://sphinxsearch.com/docs/current.html#date-time-functions
     * @inheritDoc
     */
    public function getCurrentTimestampSQL()
    {
        return 'NOW()';
    }

    /**
     * http://sphinxsearch.com/docs/current.html#sphinxql-show-databases
     * @inheritDoc
     */
    public function getListDatabasesSQL()
    {
        return 'SHOW DATABASES'; //supported, but does absolutely nothing
    }

    /**
     * http://sphinxsearch.com/docs/current.html#sphinxql-describe
     * @inheritDoc
     */
    public function getListTableColumnsSQL($table, $database = null)
    {
        //return 'DESC '.$table;
        return 'DESCRIBE '.$table;
    }

    /**
     * http://sphinxsearch.com/docs/current.html#sphinxql-show-tables
     * @inheritDoc
     */
    public function getListTablesSQL()
    {
        return 'SHOW TABLES';
    }

    /**
     * http://sphinxsearch.com/docs/current.html#sphinxql-set-transaction
     * @inheritDoc
     */
    public function getSetTransactionIsolationSQL($level)
    {
        //return 'SET SESSION TRANSACTION ISOLATION LEVEL ' . $this->_getTransactionIsolationLevelSQL($level); //mysql like
        return 'SET TRANSACTION ISOLATION LEVEL ' . $this->_getTransactionIsolationLevelSQL($level); //Supported, but does absolutely nothing
    }

    /**
     * @inheritDoc
     */
    public function getDateTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
       //return 'INT';
       return 'BIGINT';
    }

    /**
     * @inheritDoc
     */
    public function getFloatDeclarationSQL(array $fieldDeclaration)
    {
        return 'FLOAT';
    }

    /**
     * @inheritDoc
     */
    public function supportsIndexes()
    {
        return false;
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
    public function supportsPrimaryConstraints()
    {
        //технически первичного ключа нет, но к id предъявляется ряд требований как к primary
        return parent::supportsPrimaryConstraints();
    }

    /**
     * @inheritDoc
     */
    public function supportsForeignKeyConstraints()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function supportsCreateDropDatabase()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function hasNativeJsonType()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getIdentityColumnNullInsertSQL()
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function supportsViews()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getDateTimeFormatString()
    {
        return 'U';
    }

    /**
     * @inheritDoc
     */
    public function getDateTimeTzFormatString()
    {
        return $this->getDateTimeFormatString();
    }

    /**
     * @inheritDoc
     */
    public function getDateFormatString()
    {
        //return 'U';
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function getTimeFormatString()
    {
        //return 'U';
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * http://sphinxsearch.com/docs/current.html#sphinxql-select
     * @inheritDoc
     */
    protected function doModifyLimitQuery($query, $limit, $offset)
    {
        if ($limit === null) {
            $limit = PHP_INT_MAX - 1;
        }
        if ($offset === null) {
            $offset = 0;
        }
        $query .= 'LIMIT '.$limit.', '.$offset;

        return $query;
    }

    /**
     * Unknown, using default
     * @inheritDoc
     */
    public function getMaxIdentifierLength()
    {
        return parent::getMaxIdentifierLength();
    }

    /**
     * http://sphinxsearch.com/docs/current.html#conf-sql-query
     * @inheritDoc
     */
    public function getEmptyIdentityInsertSQL($tableName, $identifierColumnName)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * http://sphinxsearch.com/docs/current.html#sphinxql-truncate-rtindex
     * @inheritDoc
     */
    public function getTruncateTableSQL($tableName, $cascade = false)
    {
        $tableIdentifier = new Identifier($tableName);

        return 'TRUNCATE RTINDEX ' . $tableIdentifier->getQuotedName($this);
    }

    /**
     * @inheritDoc
     */
    public function createSavePoint($savepoint)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function releaseSavePoint($savepoint)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function rollbackSavePoint($savepoint)
    {
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * Mysql variant
     * @inheritDoc
     */
    public function quoteStringLiteral($str)
    {
        $str = str_replace('\\', '\\\\', $str); // MySQL requires backslashes to be escaped aswell.

        return parent::quoteStringLiteral($str);
    }

}
