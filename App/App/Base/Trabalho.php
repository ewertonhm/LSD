<?php

namespace App\App\Base;

use \Exception;
use \PDO;
use App\App\Aluno as ChildAluno;
use App\App\AlunoQuery as ChildAlunoQuery;
use App\App\Professor as ChildProfessor;
use App\App\ProfessorQuery as ChildProfessorQuery;
use App\App\Trabalho as ChildTrabalho;
use App\App\TrabalhoQuery as ChildTrabalhoQuery;
use App\App\Versao as ChildVersao;
use App\App\VersaoQuery as ChildVersaoQuery;
use App\App\Map\TrabalhoTableMap;
use App\App\Map\VersaoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'trabalho' table.
 *
 *
 *
 * @package    propel.generator.App.App.Base
 */
abstract class Trabalho implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\App\\Map\\TrabalhoTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the codtrabalho field.
     *
     * @var        int
     */
    protected $codtrabalho;

    /**
     * The value for the nome field.
     *
     * @var        string
     */
    protected $nome;

    /**
     * The value for the codaluno field.
     *
     * @var        int
     */
    protected $codaluno;

    /**
     * The value for the codprofessor field.
     *
     * @var        int
     */
    protected $codprofessor;

    /**
     * The value for the url field.
     *
     * @var        string
     */
    protected $url;

    /**
     * @var        ChildAluno
     */
    protected $aAluno;

    /**
     * @var        ChildProfessor
     */
    protected $aProfessor;

    /**
     * @var        ObjectCollection|ChildVersao[] Collection to store aggregation of ChildVersao objects.
     */
    protected $collVersaos;
    protected $collVersaosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVersao[]
     */
    protected $versaosScheduledForDeletion = null;

    /**
     * Initializes internal state of App\App\Base\Trabalho object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Trabalho</code> instance.  If
     * <code>obj</code> is an instance of <code>Trabalho</code>, delegates to
     * <code>equals(Trabalho)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Trabalho The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [codtrabalho] column value.
     *
     * @return int
     */
    public function getCodtrabalho()
    {
        return $this->codtrabalho;
    }

    /**
     * Get the [nome] column value.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Get the [codaluno] column value.
     *
     * @return int
     */
    public function getCodaluno()
    {
        return $this->codaluno;
    }

    /**
     * Get the [codprofessor] column value.
     *
     * @return int
     */
    public function getCodprofessor()
    {
        return $this->codprofessor;
    }

    /**
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of [codtrabalho] column.
     *
     * @param int $v new value
     * @return $this|\App\App\Trabalho The current object (for fluent API support)
     */
    public function setCodtrabalho($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->codtrabalho !== $v) {
            $this->codtrabalho = $v;
            $this->modifiedColumns[TrabalhoTableMap::COL_CODTRABALHO] = true;
        }

        return $this;
    } // setCodtrabalho()

    /**
     * Set the value of [nome] column.
     *
     * @param string $v new value
     * @return $this|\App\App\Trabalho The current object (for fluent API support)
     */
    public function setNome($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nome !== $v) {
            $this->nome = $v;
            $this->modifiedColumns[TrabalhoTableMap::COL_NOME] = true;
        }

        return $this;
    } // setNome()

    /**
     * Set the value of [codaluno] column.
     *
     * @param int $v new value
     * @return $this|\App\App\Trabalho The current object (for fluent API support)
     */
    public function setCodaluno($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->codaluno !== $v) {
            $this->codaluno = $v;
            $this->modifiedColumns[TrabalhoTableMap::COL_CODALUNO] = true;
        }

        if ($this->aAluno !== null && $this->aAluno->getCodaluno() !== $v) {
            $this->aAluno = null;
        }

        return $this;
    } // setCodaluno()

    /**
     * Set the value of [codprofessor] column.
     *
     * @param int $v new value
     * @return $this|\App\App\Trabalho The current object (for fluent API support)
     */
    public function setCodprofessor($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->codprofessor !== $v) {
            $this->codprofessor = $v;
            $this->modifiedColumns[TrabalhoTableMap::COL_CODPROFESSOR] = true;
        }

        if ($this->aProfessor !== null && $this->aProfessor->getCodprofessor() !== $v) {
            $this->aProfessor = null;
        }

        return $this;
    } // setCodprofessor()

    /**
     * Set the value of [url] column.
     *
     * @param string $v new value
     * @return $this|\App\App\Trabalho The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[TrabalhoTableMap::COL_URL] = true;
        }

        return $this;
    } // setUrl()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TrabalhoTableMap::translateFieldName('Codtrabalho', TableMap::TYPE_PHPNAME, $indexType)];
            $this->codtrabalho = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TrabalhoTableMap::translateFieldName('Nome', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nome = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TrabalhoTableMap::translateFieldName('Codaluno', TableMap::TYPE_PHPNAME, $indexType)];
            $this->codaluno = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TrabalhoTableMap::translateFieldName('Codprofessor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->codprofessor = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TrabalhoTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = TrabalhoTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\App\\Trabalho'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aAluno !== null && $this->codaluno !== $this->aAluno->getCodaluno()) {
            $this->aAluno = null;
        }
        if ($this->aProfessor !== null && $this->codprofessor !== $this->aProfessor->getCodprofessor()) {
            $this->aProfessor = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TrabalhoTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTrabalhoQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAluno = null;
            $this->aProfessor = null;
            $this->collVersaos = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Trabalho::setDeleted()
     * @see Trabalho::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrabalhoTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTrabalhoQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrabalhoTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TrabalhoTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAluno !== null) {
                if ($this->aAluno->isModified() || $this->aAluno->isNew()) {
                    $affectedRows += $this->aAluno->save($con);
                }
                $this->setAluno($this->aAluno);
            }

            if ($this->aProfessor !== null) {
                if ($this->aProfessor->isModified() || $this->aProfessor->isNew()) {
                    $affectedRows += $this->aProfessor->save($con);
                }
                $this->setProfessor($this->aProfessor);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->versaosScheduledForDeletion !== null) {
                if (!$this->versaosScheduledForDeletion->isEmpty()) {
                    \App\App\VersaoQuery::create()
                        ->filterByPrimaryKeys($this->versaosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->versaosScheduledForDeletion = null;
                }
            }

            if ($this->collVersaos !== null) {
                foreach ($this->collVersaos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TrabalhoTableMap::COL_CODTRABALHO] = true;
        if (null !== $this->codtrabalho) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TrabalhoTableMap::COL_CODTRABALHO . ')');
        }
        if (null === $this->codtrabalho) {
            try {
                $dataFetcher = $con->query("SELECT nextval('trabalho_codtrabalho_seq')");
                $this->codtrabalho = (int) $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TrabalhoTableMap::COL_CODTRABALHO)) {
            $modifiedColumns[':p' . $index++]  = 'codtrabalho';
        }
        if ($this->isColumnModified(TrabalhoTableMap::COL_NOME)) {
            $modifiedColumns[':p' . $index++]  = 'nome';
        }
        if ($this->isColumnModified(TrabalhoTableMap::COL_CODALUNO)) {
            $modifiedColumns[':p' . $index++]  = 'codaluno';
        }
        if ($this->isColumnModified(TrabalhoTableMap::COL_CODPROFESSOR)) {
            $modifiedColumns[':p' . $index++]  = 'codprofessor';
        }
        if ($this->isColumnModified(TrabalhoTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }

        $sql = sprintf(
            'INSERT INTO trabalho (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'codtrabalho':
                        $stmt->bindValue($identifier, $this->codtrabalho, PDO::PARAM_INT);
                        break;
                    case 'nome':
                        $stmt->bindValue($identifier, $this->nome, PDO::PARAM_STR);
                        break;
                    case 'codaluno':
                        $stmt->bindValue($identifier, $this->codaluno, PDO::PARAM_INT);
                        break;
                    case 'codprofessor':
                        $stmt->bindValue($identifier, $this->codprofessor, PDO::PARAM_INT);
                        break;
                    case 'url':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TrabalhoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getCodtrabalho();
                break;
            case 1:
                return $this->getNome();
                break;
            case 2:
                return $this->getCodaluno();
                break;
            case 3:
                return $this->getCodprofessor();
                break;
            case 4:
                return $this->getUrl();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Trabalho'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Trabalho'][$this->hashCode()] = true;
        $keys = TrabalhoTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCodtrabalho(),
            $keys[1] => $this->getNome(),
            $keys[2] => $this->getCodaluno(),
            $keys[3] => $this->getCodprofessor(),
            $keys[4] => $this->getUrl(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAluno) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'aluno';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'aluno';
                        break;
                    default:
                        $key = 'Aluno';
                }

                $result[$key] = $this->aAluno->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProfessor) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'professor';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'professor';
                        break;
                    default:
                        $key = 'Professor';
                }

                $result[$key] = $this->aProfessor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collVersaos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'versaos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'versaos';
                        break;
                    default:
                        $key = 'Versaos';
                }

                $result[$key] = $this->collVersaos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\App\Trabalho
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TrabalhoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\App\Trabalho
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCodtrabalho($value);
                break;
            case 1:
                $this->setNome($value);
                break;
            case 2:
                $this->setCodaluno($value);
                break;
            case 3:
                $this->setCodprofessor($value);
                break;
            case 4:
                $this->setUrl($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TrabalhoTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setCodtrabalho($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setNome($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCodaluno($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCodprofessor($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUrl($arr[$keys[4]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\App\App\Trabalho The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TrabalhoTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TrabalhoTableMap::COL_CODTRABALHO)) {
            $criteria->add(TrabalhoTableMap::COL_CODTRABALHO, $this->codtrabalho);
        }
        if ($this->isColumnModified(TrabalhoTableMap::COL_NOME)) {
            $criteria->add(TrabalhoTableMap::COL_NOME, $this->nome);
        }
        if ($this->isColumnModified(TrabalhoTableMap::COL_CODALUNO)) {
            $criteria->add(TrabalhoTableMap::COL_CODALUNO, $this->codaluno);
        }
        if ($this->isColumnModified(TrabalhoTableMap::COL_CODPROFESSOR)) {
            $criteria->add(TrabalhoTableMap::COL_CODPROFESSOR, $this->codprofessor);
        }
        if ($this->isColumnModified(TrabalhoTableMap::COL_URL)) {
            $criteria->add(TrabalhoTableMap::COL_URL, $this->url);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildTrabalhoQuery::create();
        $criteria->add(TrabalhoTableMap::COL_CODTRABALHO, $this->codtrabalho);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getCodtrabalho();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getCodtrabalho();
    }

    /**
     * Generic method to set the primary key (codtrabalho column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCodtrabalho($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getCodtrabalho();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\App\Trabalho (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNome($this->getNome());
        $copyObj->setCodaluno($this->getCodaluno());
        $copyObj->setCodprofessor($this->getCodprofessor());
        $copyObj->setUrl($this->getUrl());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getVersaos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVersao($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCodtrabalho(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\App\Trabalho Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildAluno object.
     *
     * @param  ChildAluno $v
     * @return $this|\App\App\Trabalho The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAluno(ChildAluno $v = null)
    {
        if ($v === null) {
            $this->setCodaluno(NULL);
        } else {
            $this->setCodaluno($v->getCodaluno());
        }

        $this->aAluno = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAluno object, it will not be re-added.
        if ($v !== null) {
            $v->addTrabalho($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAluno object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAluno The associated ChildAluno object.
     * @throws PropelException
     */
    public function getAluno(ConnectionInterface $con = null)
    {
        if ($this->aAluno === null && ($this->codaluno != 0)) {
            $this->aAluno = ChildAlunoQuery::create()->findPk($this->codaluno, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAluno->addTrabalhos($this);
             */
        }

        return $this->aAluno;
    }

    /**
     * Declares an association between this object and a ChildProfessor object.
     *
     * @param  ChildProfessor $v
     * @return $this|\App\App\Trabalho The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProfessor(ChildProfessor $v = null)
    {
        if ($v === null) {
            $this->setCodprofessor(NULL);
        } else {
            $this->setCodprofessor($v->getCodprofessor());
        }

        $this->aProfessor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProfessor object, it will not be re-added.
        if ($v !== null) {
            $v->addTrabalho($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProfessor object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildProfessor The associated ChildProfessor object.
     * @throws PropelException
     */
    public function getProfessor(ConnectionInterface $con = null)
    {
        if ($this->aProfessor === null && ($this->codprofessor != 0)) {
            $this->aProfessor = ChildProfessorQuery::create()->findPk($this->codprofessor, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProfessor->addTrabalhos($this);
             */
        }

        return $this->aProfessor;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Versao' == $relationName) {
            $this->initVersaos();
            return;
        }
    }

    /**
     * Clears out the collVersaos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVersaos()
     */
    public function clearVersaos()
    {
        $this->collVersaos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVersaos collection loaded partially.
     */
    public function resetPartialVersaos($v = true)
    {
        $this->collVersaosPartial = $v;
    }

    /**
     * Initializes the collVersaos collection.
     *
     * By default this just sets the collVersaos collection to an empty array (like clearcollVersaos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVersaos($overrideExisting = true)
    {
        if (null !== $this->collVersaos && !$overrideExisting) {
            return;
        }

        $collectionClassName = VersaoTableMap::getTableMap()->getCollectionClassName();

        $this->collVersaos = new $collectionClassName;
        $this->collVersaos->setModel('\App\App\Versao');
    }

    /**
     * Gets an array of ChildVersao objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTrabalho is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVersao[] List of ChildVersao objects
     * @throws PropelException
     */
    public function getVersaos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVersaosPartial && !$this->isNew();
        if (null === $this->collVersaos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVersaos) {
                // return empty collection
                $this->initVersaos();
            } else {
                $collVersaos = ChildVersaoQuery::create(null, $criteria)
                    ->filterByTrabalho($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVersaosPartial && count($collVersaos)) {
                        $this->initVersaos(false);

                        foreach ($collVersaos as $obj) {
                            if (false == $this->collVersaos->contains($obj)) {
                                $this->collVersaos->append($obj);
                            }
                        }

                        $this->collVersaosPartial = true;
                    }

                    return $collVersaos;
                }

                if ($partial && $this->collVersaos) {
                    foreach ($this->collVersaos as $obj) {
                        if ($obj->isNew()) {
                            $collVersaos[] = $obj;
                        }
                    }
                }

                $this->collVersaos = $collVersaos;
                $this->collVersaosPartial = false;
            }
        }

        return $this->collVersaos;
    }

    /**
     * Sets a collection of ChildVersao objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $versaos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTrabalho The current object (for fluent API support)
     */
    public function setVersaos(Collection $versaos, ConnectionInterface $con = null)
    {
        /** @var ChildVersao[] $versaosToDelete */
        $versaosToDelete = $this->getVersaos(new Criteria(), $con)->diff($versaos);


        $this->versaosScheduledForDeletion = $versaosToDelete;

        foreach ($versaosToDelete as $versaoRemoved) {
            $versaoRemoved->setTrabalho(null);
        }

        $this->collVersaos = null;
        foreach ($versaos as $versao) {
            $this->addVersao($versao);
        }

        $this->collVersaos = $versaos;
        $this->collVersaosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Versao objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Versao objects.
     * @throws PropelException
     */
    public function countVersaos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVersaosPartial && !$this->isNew();
        if (null === $this->collVersaos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVersaos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVersaos());
            }

            $query = ChildVersaoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTrabalho($this)
                ->count($con);
        }

        return count($this->collVersaos);
    }

    /**
     * Method called to associate a ChildVersao object to this object
     * through the ChildVersao foreign key attribute.
     *
     * @param  ChildVersao $l ChildVersao
     * @return $this|\App\App\Trabalho The current object (for fluent API support)
     */
    public function addVersao(ChildVersao $l)
    {
        if ($this->collVersaos === null) {
            $this->initVersaos();
            $this->collVersaosPartial = true;
        }

        if (!$this->collVersaos->contains($l)) {
            $this->doAddVersao($l);

            if ($this->versaosScheduledForDeletion and $this->versaosScheduledForDeletion->contains($l)) {
                $this->versaosScheduledForDeletion->remove($this->versaosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildVersao $versao The ChildVersao object to add.
     */
    protected function doAddVersao(ChildVersao $versao)
    {
        $this->collVersaos[]= $versao;
        $versao->setTrabalho($this);
    }

    /**
     * @param  ChildVersao $versao The ChildVersao object to remove.
     * @return $this|ChildTrabalho The current object (for fluent API support)
     */
    public function removeVersao(ChildVersao $versao)
    {
        if ($this->getVersaos()->contains($versao)) {
            $pos = $this->collVersaos->search($versao);
            $this->collVersaos->remove($pos);
            if (null === $this->versaosScheduledForDeletion) {
                $this->versaosScheduledForDeletion = clone $this->collVersaos;
                $this->versaosScheduledForDeletion->clear();
            }
            $this->versaosScheduledForDeletion[]= clone $versao;
            $versao->setTrabalho(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aAluno) {
            $this->aAluno->removeTrabalho($this);
        }
        if (null !== $this->aProfessor) {
            $this->aProfessor->removeTrabalho($this);
        }
        $this->codtrabalho = null;
        $this->nome = null;
        $this->codaluno = null;
        $this->codprofessor = null;
        $this->url = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collVersaos) {
                foreach ($this->collVersaos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collVersaos = null;
        $this->aAluno = null;
        $this->aProfessor = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TrabalhoTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
