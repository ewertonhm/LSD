<?php

namespace Base;

use \Curso as ChildCurso;
use \CursoQuery as ChildCursoQuery;
use \Exception;
use \PDO;
use Map\CursoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'curso' table.
 *
 *
 *
 * @method     ChildCursoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCursoQuery orderByNome($order = Criteria::ASC) Order by the nome column
 *
 * @method     ChildCursoQuery groupById() Group by the id column
 * @method     ChildCursoQuery groupByNome() Group by the nome column
 *
 * @method     ChildCursoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCursoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCursoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCursoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCursoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCursoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCursoQuery leftJoinAluno($relationAlias = null) Adds a LEFT JOIN clause to the query using the Aluno relation
 * @method     ChildCursoQuery rightJoinAluno($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Aluno relation
 * @method     ChildCursoQuery innerJoinAluno($relationAlias = null) Adds a INNER JOIN clause to the query using the Aluno relation
 *
 * @method     ChildCursoQuery joinWithAluno($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Aluno relation
 *
 * @method     ChildCursoQuery leftJoinWithAluno() Adds a LEFT JOIN clause and with to the query using the Aluno relation
 * @method     ChildCursoQuery rightJoinWithAluno() Adds a RIGHT JOIN clause and with to the query using the Aluno relation
 * @method     ChildCursoQuery innerJoinWithAluno() Adds a INNER JOIN clause and with to the query using the Aluno relation
 *
 * @method     ChildCursoQuery leftJoinProfessor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Professor relation
 * @method     ChildCursoQuery rightJoinProfessor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Professor relation
 * @method     ChildCursoQuery innerJoinProfessor($relationAlias = null) Adds a INNER JOIN clause to the query using the Professor relation
 *
 * @method     ChildCursoQuery joinWithProfessor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Professor relation
 *
 * @method     ChildCursoQuery leftJoinWithProfessor() Adds a LEFT JOIN clause and with to the query using the Professor relation
 * @method     ChildCursoQuery rightJoinWithProfessor() Adds a RIGHT JOIN clause and with to the query using the Professor relation
 * @method     ChildCursoQuery innerJoinWithProfessor() Adds a INNER JOIN clause and with to the query using the Professor relation
 *
 * @method     \AlunoQuery|\ProfessorQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCurso findOne(ConnectionInterface $con = null) Return the first ChildCurso matching the query
 * @method     ChildCurso findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCurso matching the query, or a new ChildCurso object populated from the query conditions when no match is found
 *
 * @method     ChildCurso findOneById(int $id) Return the first ChildCurso filtered by the id column
 * @method     ChildCurso findOneByNome(string $nome) Return the first ChildCurso filtered by the nome column *

 * @method     ChildCurso requirePk($key, ConnectionInterface $con = null) Return the ChildCurso by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCurso requireOne(ConnectionInterface $con = null) Return the first ChildCurso matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCurso requireOneById(int $id) Return the first ChildCurso filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCurso requireOneByNome(string $nome) Return the first ChildCurso filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCurso[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCurso objects based on current ModelCriteria
 * @method     ChildCurso[]|ObjectCollection findById(int $id) Return ChildCurso objects filtered by the id column
 * @method     ChildCurso[]|ObjectCollection findByNome(string $nome) Return ChildCurso objects filtered by the nome column
 * @method     ChildCurso[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CursoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CursoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Curso', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCursoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCursoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCursoQuery) {
            return $criteria;
        }
        $query = new ChildCursoQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCurso|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CursoTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CursoTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCurso A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nome FROM curso WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCurso $obj */
            $obj = new ChildCurso();
            $obj->hydrate($row);
            CursoTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCurso|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCursoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CursoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCursoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CursoTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCursoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CursoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CursoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CursoTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the nome column
     *
     * Example usage:
     * <code>
     * $query->filterByNome('fooValue');   // WHERE nome = 'fooValue'
     * $query->filterByNome('%fooValue%', Criteria::LIKE); // WHERE nome LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nome The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCursoQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CursoTableMap::COL_NOME, $nome, $comparison);
    }

    /**
     * Filter the query by a related \Aluno object
     *
     * @param \Aluno|ObjectCollection $aluno the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCursoQuery The current query, for fluid interface
     */
    public function filterByAluno($aluno, $comparison = null)
    {
        if ($aluno instanceof \Aluno) {
            return $this
                ->addUsingAlias(CursoTableMap::COL_ID, $aluno->getCursoId(), $comparison);
        } elseif ($aluno instanceof ObjectCollection) {
            return $this
                ->useAlunoQuery()
                ->filterByPrimaryKeys($aluno->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAluno() only accepts arguments of type \Aluno or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Aluno relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCursoQuery The current query, for fluid interface
     */
    public function joinAluno($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Aluno');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Aluno');
        }

        return $this;
    }

    /**
     * Use the Aluno relation Aluno object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AlunoQuery A secondary query class using the current class as primary query
     */
    public function useAlunoQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAluno($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Aluno', '\AlunoQuery');
    }

    /**
     * Filter the query by a related \Professor object
     *
     * @param \Professor|ObjectCollection $professor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCursoQuery The current query, for fluid interface
     */
    public function filterByProfessor($professor, $comparison = null)
    {
        if ($professor instanceof \Professor) {
            return $this
                ->addUsingAlias(CursoTableMap::COL_ID, $professor->getCursoId(), $comparison);
        } elseif ($professor instanceof ObjectCollection) {
            return $this
                ->useProfessorQuery()
                ->filterByPrimaryKeys($professor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProfessor() only accepts arguments of type \Professor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Professor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCursoQuery The current query, for fluid interface
     */
    public function joinProfessor($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Professor');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Professor');
        }

        return $this;
    }

    /**
     * Use the Professor relation Professor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProfessorQuery A secondary query class using the current class as primary query
     */
    public function useProfessorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProfessor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Professor', '\ProfessorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCurso $curso Object to remove from the list of results
     *
     * @return $this|ChildCursoQuery The current query, for fluid interface
     */
    public function prune($curso = null)
    {
        if ($curso) {
            $this->addUsingAlias(CursoTableMap::COL_ID, $curso->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the curso table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CursoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CursoTableMap::clearInstancePool();
            CursoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CursoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CursoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CursoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CursoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CursoQuery
