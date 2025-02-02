<?php

namespace Base;

use \Aluno as ChildAluno;
use \AlunoQuery as ChildAlunoQuery;
use \Professor as ChildProfessor;
use \ProfessorQuery as ChildProfessorQuery;
use \Trabalho as ChildTrabalho;
use \TrabalhoQuery as ChildTrabalhoQuery;
use \Usuario as ChildUsuario;
use \UsuarioQuery as ChildUsuarioQuery;
use \Exception;
use \PDO;
use Map\AlunoTableMap;
use Map\ProfessorTableMap;
use Map\TrabalhoTableMap;
use Map\UsuarioTableMap;
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
 * Base class that represents a row from the 'usuario' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Usuario implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UsuarioTableMap';


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
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the login field.
     *
     * @var        string
     */
    protected $login;

    /**
     * The value for the senha field.
     *
     * @var        string
     */
    protected $senha;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the admin field.
     *
     * @var        int
     */
    protected $admin;

    /**
     * @var        ObjectCollection|ChildAluno[] Collection to store aggregation of ChildAluno objects.
     */
    protected $collAlunos;
    protected $collAlunosPartial;

    /**
     * @var        ObjectCollection|ChildProfessor[] Collection to store aggregation of ChildProfessor objects.
     */
    protected $collProfessors;
    protected $collProfessorsPartial;

    /**
     * @var        ObjectCollection|ChildTrabalho[] Collection to store aggregation of ChildTrabalho objects.
     */
    protected $collTrabalhos;
    protected $collTrabalhosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAluno[]
     */
    protected $alunosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProfessor[]
     */
    protected $professorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTrabalho[]
     */
    protected $trabalhosScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Usuario object.
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
     * Compares this with another <code>Usuario</code> instance.  If
     * <code>obj</code> is an instance of <code>Usuario</code>, delegates to
     * <code>equals(Usuario)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Usuario The current object, for fluid interface
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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [login] column value.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Get the [senha] column value.
     *
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [admin] column value.
     *
     * @return int
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [login] column.
     *
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setLogin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->login !== $v) {
            $this->login = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_LOGIN] = true;
        }

        return $this;
    } // setLogin()

    /**
     * Set the value of [senha] column.
     *
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setSenha($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->senha !== $v) {
            $this->senha = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_SENHA] = true;
        }

        return $this;
    } // setSenha()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [admin] column.
     *
     * @param int $v new value
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function setAdmin($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->admin !== $v) {
            $this->admin = $v;
            $this->modifiedColumns[UsuarioTableMap::COL_ADMIN] = true;
        }

        return $this;
    } // setAdmin()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsuarioTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsuarioTableMap::translateFieldName('Login', TableMap::TYPE_PHPNAME, $indexType)];
            $this->login = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsuarioTableMap::translateFieldName('Senha', TableMap::TYPE_PHPNAME, $indexType)];
            $this->senha = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsuarioTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UsuarioTableMap::translateFieldName('Admin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->admin = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = UsuarioTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Usuario'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UsuarioTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsuarioQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAlunos = null;

            $this->collProfessors = null;

            $this->collTrabalhos = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Usuario::setDeleted()
     * @see Usuario::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsuarioQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UsuarioTableMap::DATABASE_NAME);
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
                UsuarioTableMap::addInstanceToPool($this);
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

            if ($this->alunosScheduledForDeletion !== null) {
                if (!$this->alunosScheduledForDeletion->isEmpty()) {
                    foreach ($this->alunosScheduledForDeletion as $aluno) {
                        // need to save related object because we set the relation to null
                        $aluno->save($con);
                    }
                    $this->alunosScheduledForDeletion = null;
                }
            }

            if ($this->collAlunos !== null) {
                foreach ($this->collAlunos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->professorsScheduledForDeletion !== null) {
                if (!$this->professorsScheduledForDeletion->isEmpty()) {
                    foreach ($this->professorsScheduledForDeletion as $professor) {
                        // need to save related object because we set the relation to null
                        $professor->save($con);
                    }
                    $this->professorsScheduledForDeletion = null;
                }
            }

            if ($this->collProfessors !== null) {
                foreach ($this->collProfessors as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->trabalhosScheduledForDeletion !== null) {
                if (!$this->trabalhosScheduledForDeletion->isEmpty()) {
                    foreach ($this->trabalhosScheduledForDeletion as $trabalho) {
                        // need to save related object because we set the relation to null
                        $trabalho->save($con);
                    }
                    $this->trabalhosScheduledForDeletion = null;
                }
            }

            if ($this->collTrabalhos !== null) {
                foreach ($this->collTrabalhos as $referrerFK) {
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

        $this->modifiedColumns[UsuarioTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UsuarioTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('usuario_id_seq')");
                $this->id = (int) $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsuarioTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_LOGIN)) {
            $modifiedColumns[':p' . $index++]  = 'login';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_SENHA)) {
            $modifiedColumns[':p' . $index++]  = 'senha';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_ADMIN)) {
            $modifiedColumns[':p' . $index++]  = 'admin';
        }

        $sql = sprintf(
            'INSERT INTO usuario (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'login':
                        $stmt->bindValue($identifier, $this->login, PDO::PARAM_STR);
                        break;
                    case 'senha':
                        $stmt->bindValue($identifier, $this->senha, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'admin':
                        $stmt->bindValue($identifier, $this->admin, PDO::PARAM_INT);
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
        $pos = UsuarioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getId();
                break;
            case 1:
                return $this->getLogin();
                break;
            case 2:
                return $this->getSenha();
                break;
            case 3:
                return $this->getEmail();
                break;
            case 4:
                return $this->getAdmin();
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

        if (isset($alreadyDumpedObjects['Usuario'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Usuario'][$this->hashCode()] = true;
        $keys = UsuarioTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLogin(),
            $keys[2] => $this->getSenha(),
            $keys[3] => $this->getEmail(),
            $keys[4] => $this->getAdmin(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAlunos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'alunos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'alunos';
                        break;
                    default:
                        $key = 'Alunos';
                }

                $result[$key] = $this->collAlunos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProfessors) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'professors';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'professors';
                        break;
                    default:
                        $key = 'Professors';
                }

                $result[$key] = $this->collProfessors->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTrabalhos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'trabalhos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'trabalhos';
                        break;
                    default:
                        $key = 'Trabalhos';
                }

                $result[$key] = $this->collTrabalhos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Usuario
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsuarioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Usuario
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setLogin($value);
                break;
            case 2:
                $this->setSenha($value);
                break;
            case 3:
                $this->setEmail($value);
                break;
            case 4:
                $this->setAdmin($value);
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
        $keys = UsuarioTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLogin($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSenha($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmail($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setAdmin($arr[$keys[4]]);
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
     * @return $this|\Usuario The current object, for fluid interface
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
        $criteria = new Criteria(UsuarioTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsuarioTableMap::COL_ID)) {
            $criteria->add(UsuarioTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_LOGIN)) {
            $criteria->add(UsuarioTableMap::COL_LOGIN, $this->login);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_SENHA)) {
            $criteria->add(UsuarioTableMap::COL_SENHA, $this->senha);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_EMAIL)) {
            $criteria->add(UsuarioTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UsuarioTableMap::COL_ADMIN)) {
            $criteria->add(UsuarioTableMap::COL_ADMIN, $this->admin);
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
        $criteria = ChildUsuarioQuery::create();
        $criteria->add(UsuarioTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getId();

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
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Usuario (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLogin($this->getLogin());
        $copyObj->setSenha($this->getSenha());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setAdmin($this->getAdmin());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAlunos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAluno($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProfessors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProfessor($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTrabalhos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTrabalho($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Usuario Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Aluno' == $relationName) {
            $this->initAlunos();
            return;
        }
        if ('Professor' == $relationName) {
            $this->initProfessors();
            return;
        }
        if ('Trabalho' == $relationName) {
            $this->initTrabalhos();
            return;
        }
    }

    /**
     * Clears out the collAlunos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAlunos()
     */
    public function clearAlunos()
    {
        $this->collAlunos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAlunos collection loaded partially.
     */
    public function resetPartialAlunos($v = true)
    {
        $this->collAlunosPartial = $v;
    }

    /**
     * Initializes the collAlunos collection.
     *
     * By default this just sets the collAlunos collection to an empty array (like clearcollAlunos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAlunos($overrideExisting = true)
    {
        if (null !== $this->collAlunos && !$overrideExisting) {
            return;
        }

        $collectionClassName = AlunoTableMap::getTableMap()->getCollectionClassName();

        $this->collAlunos = new $collectionClassName;
        $this->collAlunos->setModel('\Aluno');
    }

    /**
     * Gets an array of ChildAluno objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAluno[] List of ChildAluno objects
     * @throws PropelException
     */
    public function getAlunos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAlunosPartial && !$this->isNew();
        if (null === $this->collAlunos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAlunos) {
                // return empty collection
                $this->initAlunos();
            } else {
                $collAlunos = ChildAlunoQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAlunosPartial && count($collAlunos)) {
                        $this->initAlunos(false);

                        foreach ($collAlunos as $obj) {
                            if (false == $this->collAlunos->contains($obj)) {
                                $this->collAlunos->append($obj);
                            }
                        }

                        $this->collAlunosPartial = true;
                    }

                    return $collAlunos;
                }

                if ($partial && $this->collAlunos) {
                    foreach ($this->collAlunos as $obj) {
                        if ($obj->isNew()) {
                            $collAlunos[] = $obj;
                        }
                    }
                }

                $this->collAlunos = $collAlunos;
                $this->collAlunosPartial = false;
            }
        }

        return $this->collAlunos;
    }

    /**
     * Sets a collection of ChildAluno objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $alunos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setAlunos(Collection $alunos, ConnectionInterface $con = null)
    {
        /** @var ChildAluno[] $alunosToDelete */
        $alunosToDelete = $this->getAlunos(new Criteria(), $con)->diff($alunos);


        $this->alunosScheduledForDeletion = $alunosToDelete;

        foreach ($alunosToDelete as $alunoRemoved) {
            $alunoRemoved->setUsuario(null);
        }

        $this->collAlunos = null;
        foreach ($alunos as $aluno) {
            $this->addAluno($aluno);
        }

        $this->collAlunos = $alunos;
        $this->collAlunosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Aluno objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Aluno objects.
     * @throws PropelException
     */
    public function countAlunos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAlunosPartial && !$this->isNew();
        if (null === $this->collAlunos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAlunos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAlunos());
            }

            $query = ChildAlunoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collAlunos);
    }

    /**
     * Method called to associate a ChildAluno object to this object
     * through the ChildAluno foreign key attribute.
     *
     * @param  ChildAluno $l ChildAluno
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addAluno(ChildAluno $l)
    {
        if ($this->collAlunos === null) {
            $this->initAlunos();
            $this->collAlunosPartial = true;
        }

        if (!$this->collAlunos->contains($l)) {
            $this->doAddAluno($l);

            if ($this->alunosScheduledForDeletion and $this->alunosScheduledForDeletion->contains($l)) {
                $this->alunosScheduledForDeletion->remove($this->alunosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAluno $aluno The ChildAluno object to add.
     */
    protected function doAddAluno(ChildAluno $aluno)
    {
        $this->collAlunos[]= $aluno;
        $aluno->setUsuario($this);
    }

    /**
     * @param  ChildAluno $aluno The ChildAluno object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeAluno(ChildAluno $aluno)
    {
        if ($this->getAlunos()->contains($aluno)) {
            $pos = $this->collAlunos->search($aluno);
            $this->collAlunos->remove($pos);
            if (null === $this->alunosScheduledForDeletion) {
                $this->alunosScheduledForDeletion = clone $this->collAlunos;
                $this->alunosScheduledForDeletion->clear();
            }
            $this->alunosScheduledForDeletion[]= $aluno;
            $aluno->setUsuario(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Usuario is new, it will return
     * an empty collection; or if this Usuario has previously
     * been saved, it will retrieve related Alunos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Usuario.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAluno[] List of ChildAluno objects
     */
    public function getAlunosJoinCurso(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAlunoQuery::create(null, $criteria);
        $query->joinWith('Curso', $joinBehavior);

        return $this->getAlunos($query, $con);
    }

    /**
     * Clears out the collProfessors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProfessors()
     */
    public function clearProfessors()
    {
        $this->collProfessors = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProfessors collection loaded partially.
     */
    public function resetPartialProfessors($v = true)
    {
        $this->collProfessorsPartial = $v;
    }

    /**
     * Initializes the collProfessors collection.
     *
     * By default this just sets the collProfessors collection to an empty array (like clearcollProfessors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProfessors($overrideExisting = true)
    {
        if (null !== $this->collProfessors && !$overrideExisting) {
            return;
        }

        $collectionClassName = ProfessorTableMap::getTableMap()->getCollectionClassName();

        $this->collProfessors = new $collectionClassName;
        $this->collProfessors->setModel('\Professor');
    }

    /**
     * Gets an array of ChildProfessor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProfessor[] List of ChildProfessor objects
     * @throws PropelException
     */
    public function getProfessors(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProfessorsPartial && !$this->isNew();
        if (null === $this->collProfessors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProfessors) {
                // return empty collection
                $this->initProfessors();
            } else {
                $collProfessors = ChildProfessorQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProfessorsPartial && count($collProfessors)) {
                        $this->initProfessors(false);

                        foreach ($collProfessors as $obj) {
                            if (false == $this->collProfessors->contains($obj)) {
                                $this->collProfessors->append($obj);
                            }
                        }

                        $this->collProfessorsPartial = true;
                    }

                    return $collProfessors;
                }

                if ($partial && $this->collProfessors) {
                    foreach ($this->collProfessors as $obj) {
                        if ($obj->isNew()) {
                            $collProfessors[] = $obj;
                        }
                    }
                }

                $this->collProfessors = $collProfessors;
                $this->collProfessorsPartial = false;
            }
        }

        return $this->collProfessors;
    }

    /**
     * Sets a collection of ChildProfessor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $professors A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setProfessors(Collection $professors, ConnectionInterface $con = null)
    {
        /** @var ChildProfessor[] $professorsToDelete */
        $professorsToDelete = $this->getProfessors(new Criteria(), $con)->diff($professors);


        $this->professorsScheduledForDeletion = $professorsToDelete;

        foreach ($professorsToDelete as $professorRemoved) {
            $professorRemoved->setUsuario(null);
        }

        $this->collProfessors = null;
        foreach ($professors as $professor) {
            $this->addProfessor($professor);
        }

        $this->collProfessors = $professors;
        $this->collProfessorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Professor objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Professor objects.
     * @throws PropelException
     */
    public function countProfessors(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProfessorsPartial && !$this->isNew();
        if (null === $this->collProfessors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProfessors) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProfessors());
            }

            $query = ChildProfessorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collProfessors);
    }

    /**
     * Method called to associate a ChildProfessor object to this object
     * through the ChildProfessor foreign key attribute.
     *
     * @param  ChildProfessor $l ChildProfessor
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addProfessor(ChildProfessor $l)
    {
        if ($this->collProfessors === null) {
            $this->initProfessors();
            $this->collProfessorsPartial = true;
        }

        if (!$this->collProfessors->contains($l)) {
            $this->doAddProfessor($l);

            if ($this->professorsScheduledForDeletion and $this->professorsScheduledForDeletion->contains($l)) {
                $this->professorsScheduledForDeletion->remove($this->professorsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildProfessor $professor The ChildProfessor object to add.
     */
    protected function doAddProfessor(ChildProfessor $professor)
    {
        $this->collProfessors[]= $professor;
        $professor->setUsuario($this);
    }

    /**
     * @param  ChildProfessor $professor The ChildProfessor object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeProfessor(ChildProfessor $professor)
    {
        if ($this->getProfessors()->contains($professor)) {
            $pos = $this->collProfessors->search($professor);
            $this->collProfessors->remove($pos);
            if (null === $this->professorsScheduledForDeletion) {
                $this->professorsScheduledForDeletion = clone $this->collProfessors;
                $this->professorsScheduledForDeletion->clear();
            }
            $this->professorsScheduledForDeletion[]= $professor;
            $professor->setUsuario(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Usuario is new, it will return
     * an empty collection; or if this Usuario has previously
     * been saved, it will retrieve related Professors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Usuario.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildProfessor[] List of ChildProfessor objects
     */
    public function getProfessorsJoinCurso(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildProfessorQuery::create(null, $criteria);
        $query->joinWith('Curso', $joinBehavior);

        return $this->getProfessors($query, $con);
    }

    /**
     * Clears out the collTrabalhos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTrabalhos()
     */
    public function clearTrabalhos()
    {
        $this->collTrabalhos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTrabalhos collection loaded partially.
     */
    public function resetPartialTrabalhos($v = true)
    {
        $this->collTrabalhosPartial = $v;
    }

    /**
     * Initializes the collTrabalhos collection.
     *
     * By default this just sets the collTrabalhos collection to an empty array (like clearcollTrabalhos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTrabalhos($overrideExisting = true)
    {
        if (null !== $this->collTrabalhos && !$overrideExisting) {
            return;
        }

        $collectionClassName = TrabalhoTableMap::getTableMap()->getCollectionClassName();

        $this->collTrabalhos = new $collectionClassName;
        $this->collTrabalhos->setModel('\Trabalho');
    }

    /**
     * Gets an array of ChildTrabalho objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsuario is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTrabalho[] List of ChildTrabalho objects
     * @throws PropelException
     */
    public function getTrabalhos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTrabalhosPartial && !$this->isNew();
        if (null === $this->collTrabalhos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTrabalhos) {
                // return empty collection
                $this->initTrabalhos();
            } else {
                $collTrabalhos = ChildTrabalhoQuery::create(null, $criteria)
                    ->filterByUsuario($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTrabalhosPartial && count($collTrabalhos)) {
                        $this->initTrabalhos(false);

                        foreach ($collTrabalhos as $obj) {
                            if (false == $this->collTrabalhos->contains($obj)) {
                                $this->collTrabalhos->append($obj);
                            }
                        }

                        $this->collTrabalhosPartial = true;
                    }

                    return $collTrabalhos;
                }

                if ($partial && $this->collTrabalhos) {
                    foreach ($this->collTrabalhos as $obj) {
                        if ($obj->isNew()) {
                            $collTrabalhos[] = $obj;
                        }
                    }
                }

                $this->collTrabalhos = $collTrabalhos;
                $this->collTrabalhosPartial = false;
            }
        }

        return $this->collTrabalhos;
    }

    /**
     * Sets a collection of ChildTrabalho objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $trabalhos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function setTrabalhos(Collection $trabalhos, ConnectionInterface $con = null)
    {
        /** @var ChildTrabalho[] $trabalhosToDelete */
        $trabalhosToDelete = $this->getTrabalhos(new Criteria(), $con)->diff($trabalhos);


        $this->trabalhosScheduledForDeletion = $trabalhosToDelete;

        foreach ($trabalhosToDelete as $trabalhoRemoved) {
            $trabalhoRemoved->setUsuario(null);
        }

        $this->collTrabalhos = null;
        foreach ($trabalhos as $trabalho) {
            $this->addTrabalho($trabalho);
        }

        $this->collTrabalhos = $trabalhos;
        $this->collTrabalhosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Trabalho objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Trabalho objects.
     * @throws PropelException
     */
    public function countTrabalhos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTrabalhosPartial && !$this->isNew();
        if (null === $this->collTrabalhos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTrabalhos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTrabalhos());
            }

            $query = ChildTrabalhoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsuario($this)
                ->count($con);
        }

        return count($this->collTrabalhos);
    }

    /**
     * Method called to associate a ChildTrabalho object to this object
     * through the ChildTrabalho foreign key attribute.
     *
     * @param  ChildTrabalho $l ChildTrabalho
     * @return $this|\Usuario The current object (for fluent API support)
     */
    public function addTrabalho(ChildTrabalho $l)
    {
        if ($this->collTrabalhos === null) {
            $this->initTrabalhos();
            $this->collTrabalhosPartial = true;
        }

        if (!$this->collTrabalhos->contains($l)) {
            $this->doAddTrabalho($l);

            if ($this->trabalhosScheduledForDeletion and $this->trabalhosScheduledForDeletion->contains($l)) {
                $this->trabalhosScheduledForDeletion->remove($this->trabalhosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTrabalho $trabalho The ChildTrabalho object to add.
     */
    protected function doAddTrabalho(ChildTrabalho $trabalho)
    {
        $this->collTrabalhos[]= $trabalho;
        $trabalho->setUsuario($this);
    }

    /**
     * @param  ChildTrabalho $trabalho The ChildTrabalho object to remove.
     * @return $this|ChildUsuario The current object (for fluent API support)
     */
    public function removeTrabalho(ChildTrabalho $trabalho)
    {
        if ($this->getTrabalhos()->contains($trabalho)) {
            $pos = $this->collTrabalhos->search($trabalho);
            $this->collTrabalhos->remove($pos);
            if (null === $this->trabalhosScheduledForDeletion) {
                $this->trabalhosScheduledForDeletion = clone $this->collTrabalhos;
                $this->trabalhosScheduledForDeletion->clear();
            }
            $this->trabalhosScheduledForDeletion[]= $trabalho;
            $trabalho->setUsuario(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Usuario is new, it will return
     * an empty collection; or if this Usuario has previously
     * been saved, it will retrieve related Trabalhos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Usuario.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTrabalho[] List of ChildTrabalho objects
     */
    public function getTrabalhosJoinProfessor(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTrabalhoQuery::create(null, $criteria);
        $query->joinWith('Professor', $joinBehavior);

        return $this->getTrabalhos($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->login = null;
        $this->senha = null;
        $this->email = null;
        $this->admin = null;
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
            if ($this->collAlunos) {
                foreach ($this->collAlunos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProfessors) {
                foreach ($this->collProfessors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTrabalhos) {
                foreach ($this->collTrabalhos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAlunos = null;
        $this->collProfessors = null;
        $this->collTrabalhos = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsuarioTableMap::DEFAULT_STRING_FORMAT);
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
