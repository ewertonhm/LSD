<?php

namespace App\App\Base;

use \Exception;
use \PDO;
use App\App\Aluno as ChildAluno;
use App\App\AlunoQuery as ChildAlunoQuery;
use App\App\Map\AlunoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'aluno' table.
 *
 *
 *
 * @method     ChildAlunoQuery orderByCodaluno($order = Criteria::ASC) Order by the codaluno column
 * @method     ChildAlunoQuery orderByRa($order = Criteria::ASC) Order by the ra column
 * @method     ChildAlunoQuery orderByNome($order = Criteria::ASC) Order by the nome column
 *
 * @method     ChildAlunoQuery groupByCodaluno() Group by the codaluno column
 * @method     ChildAlunoQuery groupByRa() Group by the ra column
 * @method     ChildAlunoQuery groupByNome() Group by the nome column
 *
 * @method     ChildAlunoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAlunoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAlunoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAlunoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAlunoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAlunoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAlunoQuery leftJoinTrabalho($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trabalho relation
 * @method     ChildAlunoQuery rightJoinTrabalho($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trabalho relation
 * @method     ChildAlunoQuery innerJoinTrabalho($relationAlias = null) Adds a INNER JOIN clause to the query using the Trabalho relation
 *
 * @method     ChildAlunoQuery joinWithTrabalho($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Trabalho relation
 *
 * @method     ChildAlunoQuery leftJoinWithTrabalho() Adds a LEFT JOIN clause and with to the query using the Trabalho relation
 * @method     ChildAlunoQuery rightJoinWithTrabalho() Adds a RIGHT JOIN clause and with to the query using the Trabalho relation
 * @method     ChildAlunoQuery innerJoinWithTrabalho() Adds a INNER JOIN clause and with to the query using the Trabalho relation
 *
 * @method     \App\App\TrabalhoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAluno findOne(ConnectionInterface $con = null) Return the first ChildAluno matching the query
 * @method     ChildAluno findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAluno matching the query, or a new ChildAluno object populated from the query conditions when no match is found
 *
 * @method     ChildAluno findOneByCodaluno(int $codaluno) Return the first ChildAluno filtered by the codaluno column
 * @method     ChildAluno findOneByRa(int $ra) Return the first ChildAluno filtered by the ra column
 * @method     ChildAluno findOneByNome(string $nome) Return the first ChildAluno filtered by the nome column *

 * @method     ChildAluno requirePk($key, ConnectionInterface $con = null) Return the ChildAluno by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAluno requireOne(ConnectionInterface $con = null) Return the first ChildAluno matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAluno requireOneByCodaluno(int $codaluno) Return the first ChildAluno filtered by the codaluno column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAluno requireOneByRa(int $ra) Return the first ChildAluno filtered by the ra column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAluno requireOneByNome(string $nome) Return the first ChildAluno filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAluno[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAluno objects based on current ModelCriteria
 * @method     ChildAluno[]|ObjectCollection findByCodaluno(int $codaluno) Return ChildAluno objects filtered by the codaluno column
 * @method     ChildAluno[]|ObjectCollection findByRa(int $ra) Return ChildAluno objects filtered by the ra column
 * @method     ChildAluno[]|ObjectCollection findByNome(string $nome) Return ChildAluno objects filtered by the nome column
 * @method     ChildAluno[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AlunoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\App\Base\AlunoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\App\\Aluno', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAlunoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAlunoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAlunoQuery) {
            return $criteria;
        }
        $query = new ChildAlunoQuery();
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
     * @return ChildAluno|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AlunoTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AlunoTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAluno A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT codaluno, ra, nome FROM aluno WHERE codaluno = :p0';
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
            /** @var ChildAluno $obj */
            $obj = new ChildAluno();
            $obj->hydrate($row);
            AlunoTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAluno|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAlunoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AlunoTableMap::COL_CODALUNO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAlunoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AlunoTableMap::COL_CODALUNO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the codaluno column
     *
     * Example usage:
     * <code>
     * $query->filterByCodaluno(1234); // WHERE codaluno = 1234
     * $query->filterByCodaluno(array(12, 34)); // WHERE codaluno IN (12, 34)
     * $query->filterByCodaluno(array('min' => 12)); // WHERE codaluno > 12
     * </code>
     *
     * @param     mixed $codaluno The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlunoQuery The current query, for fluid interface
     */
    public function filterByCodaluno($codaluno = null, $comparison = null)
    {
        if (is_array($codaluno)) {
            $useMinMax = false;
            if (isset($codaluno['min'])) {
                $this->addUsingAlias(AlunoTableMap::COL_CODALUNO, $codaluno['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($codaluno['max'])) {
                $this->addUsingAlias(AlunoTableMap::COL_CODALUNO, $codaluno['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlunoTableMap::COL_CODALUNO, $codaluno, $comparison);
    }

    /**
     * Filter the query on the ra column
     *
     * Example usage:
     * <code>
     * $query->filterByRa(1234); // WHERE ra = 1234
     * $query->filterByRa(array(12, 34)); // WHERE ra IN (12, 34)
     * $query->filterByRa(array('min' => 12)); // WHERE ra > 12
     * </code>
     *
     * @param     mixed $ra The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlunoQuery The current query, for fluid interface
     */
    public function filterByRa($ra = null, $comparison = null)
    {
        if (is_array($ra)) {
            $useMinMax = false;
            if (isset($ra['min'])) {
                $this->addUsingAlias(AlunoTableMap::COL_RA, $ra['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ra['max'])) {
                $this->addUsingAlias(AlunoTableMap::COL_RA, $ra['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlunoTableMap::COL_RA, $ra, $comparison);
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
     * @return $this|ChildAlunoQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlunoTableMap::COL_NOME, $nome, $comparison);
    }

    /**
     * Filter the query by a related \App\App\Trabalho object
     *
     * @param \App\App\Trabalho|ObjectCollection $trabalho the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlunoQuery The current query, for fluid interface
     */
    public function filterByTrabalho($trabalho, $comparison = null)
    {
        if ($trabalho instanceof \App\App\Trabalho) {
            return $this
                ->addUsingAlias(AlunoTableMap::COL_CODALUNO, $trabalho->getCodaluno(), $comparison);
        } elseif ($trabalho instanceof ObjectCollection) {
            return $this
                ->useTrabalhoQuery()
                ->filterByPrimaryKeys($trabalho->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTrabalho() only accepts arguments of type \App\App\Trabalho or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Trabalho relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAlunoQuery The current query, for fluid interface
     */
    public function joinTrabalho($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Trabalho');

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
            $this->addJoinObject($join, 'Trabalho');
        }

        return $this;
    }

    /**
     * Use the Trabalho relation Trabalho object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\App\TrabalhoQuery A secondary query class using the current class as primary query
     */
    public function useTrabalhoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTrabalho($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Trabalho', '\App\App\TrabalhoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAluno $aluno Object to remove from the list of results
     *
     * @return $this|ChildAlunoQuery The current query, for fluid interface
     */
    public function prune($aluno = null)
    {
        if ($aluno) {
            $this->addUsingAlias(AlunoTableMap::COL_CODALUNO, $aluno->getCodaluno(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the aluno table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlunoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AlunoTableMap::clearInstancePool();
            AlunoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AlunoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AlunoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AlunoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AlunoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AlunoQuery
