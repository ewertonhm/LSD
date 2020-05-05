<?php

namespace App\App\Base;

use \Exception;
use \PDO;
use App\App\Trabalho as ChildTrabalho;
use App\App\TrabalhoQuery as ChildTrabalhoQuery;
use App\App\Map\TrabalhoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'trabalho' table.
 *
 *
 *
 * @method     ChildTrabalhoQuery orderByCodtrabalho($order = Criteria::ASC) Order by the codtrabalho column
 * @method     ChildTrabalhoQuery orderByNome($order = Criteria::ASC) Order by the nome column
 * @method     ChildTrabalhoQuery orderByCodaluno($order = Criteria::ASC) Order by the codaluno column
 * @method     ChildTrabalhoQuery orderByCodprofessor($order = Criteria::ASC) Order by the codprofessor column
 * @method     ChildTrabalhoQuery orderByUrl($order = Criteria::ASC) Order by the url column
 *
 * @method     ChildTrabalhoQuery groupByCodtrabalho() Group by the codtrabalho column
 * @method     ChildTrabalhoQuery groupByNome() Group by the nome column
 * @method     ChildTrabalhoQuery groupByCodaluno() Group by the codaluno column
 * @method     ChildTrabalhoQuery groupByCodprofessor() Group by the codprofessor column
 * @method     ChildTrabalhoQuery groupByUrl() Group by the url column
 *
 * @method     ChildTrabalhoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTrabalhoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTrabalhoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTrabalhoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTrabalhoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTrabalhoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTrabalhoQuery leftJoinAluno($relationAlias = null) Adds a LEFT JOIN clause to the query using the Aluno relation
 * @method     ChildTrabalhoQuery rightJoinAluno($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Aluno relation
 * @method     ChildTrabalhoQuery innerJoinAluno($relationAlias = null) Adds a INNER JOIN clause to the query using the Aluno relation
 *
 * @method     ChildTrabalhoQuery joinWithAluno($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Aluno relation
 *
 * @method     ChildTrabalhoQuery leftJoinWithAluno() Adds a LEFT JOIN clause and with to the query using the Aluno relation
 * @method     ChildTrabalhoQuery rightJoinWithAluno() Adds a RIGHT JOIN clause and with to the query using the Aluno relation
 * @method     ChildTrabalhoQuery innerJoinWithAluno() Adds a INNER JOIN clause and with to the query using the Aluno relation
 *
 * @method     ChildTrabalhoQuery leftJoinProfessor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Professor relation
 * @method     ChildTrabalhoQuery rightJoinProfessor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Professor relation
 * @method     ChildTrabalhoQuery innerJoinProfessor($relationAlias = null) Adds a INNER JOIN clause to the query using the Professor relation
 *
 * @method     ChildTrabalhoQuery joinWithProfessor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Professor relation
 *
 * @method     ChildTrabalhoQuery leftJoinWithProfessor() Adds a LEFT JOIN clause and with to the query using the Professor relation
 * @method     ChildTrabalhoQuery rightJoinWithProfessor() Adds a RIGHT JOIN clause and with to the query using the Professor relation
 * @method     ChildTrabalhoQuery innerJoinWithProfessor() Adds a INNER JOIN clause and with to the query using the Professor relation
 *
 * @method     ChildTrabalhoQuery leftJoinVersao($relationAlias = null) Adds a LEFT JOIN clause to the query using the Versao relation
 * @method     ChildTrabalhoQuery rightJoinVersao($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Versao relation
 * @method     ChildTrabalhoQuery innerJoinVersao($relationAlias = null) Adds a INNER JOIN clause to the query using the Versao relation
 *
 * @method     ChildTrabalhoQuery joinWithVersao($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Versao relation
 *
 * @method     ChildTrabalhoQuery leftJoinWithVersao() Adds a LEFT JOIN clause and with to the query using the Versao relation
 * @method     ChildTrabalhoQuery rightJoinWithVersao() Adds a RIGHT JOIN clause and with to the query using the Versao relation
 * @method     ChildTrabalhoQuery innerJoinWithVersao() Adds a INNER JOIN clause and with to the query using the Versao relation
 *
 * @method     \App\App\AlunoQuery|\App\App\ProfessorQuery|\App\App\VersaoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTrabalho findOne(ConnectionInterface $con = null) Return the first ChildTrabalho matching the query
 * @method     ChildTrabalho findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTrabalho matching the query, or a new ChildTrabalho object populated from the query conditions when no match is found
 *
 * @method     ChildTrabalho findOneByCodtrabalho(int $codtrabalho) Return the first ChildTrabalho filtered by the codtrabalho column
 * @method     ChildTrabalho findOneByNome(string $nome) Return the first ChildTrabalho filtered by the nome column
 * @method     ChildTrabalho findOneByCodaluno(int $codaluno) Return the first ChildTrabalho filtered by the codaluno column
 * @method     ChildTrabalho findOneByCodprofessor(int $codprofessor) Return the first ChildTrabalho filtered by the codprofessor column
 * @method     ChildTrabalho findOneByUrl(string $url) Return the first ChildTrabalho filtered by the url column *

 * @method     ChildTrabalho requirePk($key, ConnectionInterface $con = null) Return the ChildTrabalho by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrabalho requireOne(ConnectionInterface $con = null) Return the first ChildTrabalho matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrabalho requireOneByCodtrabalho(int $codtrabalho) Return the first ChildTrabalho filtered by the codtrabalho column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrabalho requireOneByNome(string $nome) Return the first ChildTrabalho filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrabalho requireOneByCodaluno(int $codaluno) Return the first ChildTrabalho filtered by the codaluno column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrabalho requireOneByCodprofessor(int $codprofessor) Return the first ChildTrabalho filtered by the codprofessor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrabalho requireOneByUrl(string $url) Return the first ChildTrabalho filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrabalho[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTrabalho objects based on current ModelCriteria
 * @method     ChildTrabalho[]|ObjectCollection findByCodtrabalho(int $codtrabalho) Return ChildTrabalho objects filtered by the codtrabalho column
 * @method     ChildTrabalho[]|ObjectCollection findByNome(string $nome) Return ChildTrabalho objects filtered by the nome column
 * @method     ChildTrabalho[]|ObjectCollection findByCodaluno(int $codaluno) Return ChildTrabalho objects filtered by the codaluno column
 * @method     ChildTrabalho[]|ObjectCollection findByCodprofessor(int $codprofessor) Return ChildTrabalho objects filtered by the codprofessor column
 * @method     ChildTrabalho[]|ObjectCollection findByUrl(string $url) Return ChildTrabalho objects filtered by the url column
 * @method     ChildTrabalho[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TrabalhoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\App\Base\TrabalhoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\App\\Trabalho', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTrabalhoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTrabalhoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTrabalhoQuery) {
            return $criteria;
        }
        $query = new ChildTrabalhoQuery();
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
     * @return ChildTrabalho|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TrabalhoTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TrabalhoTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTrabalho A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT codtrabalho, nome, codaluno, codprofessor, url FROM trabalho WHERE codtrabalho = :p0';
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
            /** @var ChildTrabalho $obj */
            $obj = new ChildTrabalho();
            $obj->hydrate($row);
            TrabalhoTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTrabalho|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TrabalhoTableMap::COL_CODTRABALHO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TrabalhoTableMap::COL_CODTRABALHO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the codtrabalho column
     *
     * Example usage:
     * <code>
     * $query->filterByCodtrabalho(1234); // WHERE codtrabalho = 1234
     * $query->filterByCodtrabalho(array(12, 34)); // WHERE codtrabalho IN (12, 34)
     * $query->filterByCodtrabalho(array('min' => 12)); // WHERE codtrabalho > 12
     * </code>
     *
     * @param     mixed $codtrabalho The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByCodtrabalho($codtrabalho = null, $comparison = null)
    {
        if (is_array($codtrabalho)) {
            $useMinMax = false;
            if (isset($codtrabalho['min'])) {
                $this->addUsingAlias(TrabalhoTableMap::COL_CODTRABALHO, $codtrabalho['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($codtrabalho['max'])) {
                $this->addUsingAlias(TrabalhoTableMap::COL_CODTRABALHO, $codtrabalho['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrabalhoTableMap::COL_CODTRABALHO, $codtrabalho, $comparison);
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
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrabalhoTableMap::COL_NOME, $nome, $comparison);
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
     * @see       filterByAluno()
     *
     * @param     mixed $codaluno The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByCodaluno($codaluno = null, $comparison = null)
    {
        if (is_array($codaluno)) {
            $useMinMax = false;
            if (isset($codaluno['min'])) {
                $this->addUsingAlias(TrabalhoTableMap::COL_CODALUNO, $codaluno['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($codaluno['max'])) {
                $this->addUsingAlias(TrabalhoTableMap::COL_CODALUNO, $codaluno['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrabalhoTableMap::COL_CODALUNO, $codaluno, $comparison);
    }

    /**
     * Filter the query on the codprofessor column
     *
     * Example usage:
     * <code>
     * $query->filterByCodprofessor(1234); // WHERE codprofessor = 1234
     * $query->filterByCodprofessor(array(12, 34)); // WHERE codprofessor IN (12, 34)
     * $query->filterByCodprofessor(array('min' => 12)); // WHERE codprofessor > 12
     * </code>
     *
     * @see       filterByProfessor()
     *
     * @param     mixed $codprofessor The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByCodprofessor($codprofessor = null, $comparison = null)
    {
        if (is_array($codprofessor)) {
            $useMinMax = false;
            if (isset($codprofessor['min'])) {
                $this->addUsingAlias(TrabalhoTableMap::COL_CODPROFESSOR, $codprofessor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($codprofessor['max'])) {
                $this->addUsingAlias(TrabalhoTableMap::COL_CODPROFESSOR, $codprofessor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrabalhoTableMap::COL_CODPROFESSOR, $codprofessor, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%', Criteria::LIKE); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrabalhoTableMap::COL_URL, $url, $comparison);
    }

    /**
     * Filter the query by a related \App\App\Aluno object
     *
     * @param \App\App\Aluno|ObjectCollection $aluno The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByAluno($aluno, $comparison = null)
    {
        if ($aluno instanceof \App\App\Aluno) {
            return $this
                ->addUsingAlias(TrabalhoTableMap::COL_CODALUNO, $aluno->getCodaluno(), $comparison);
        } elseif ($aluno instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TrabalhoTableMap::COL_CODALUNO, $aluno->toKeyValue('PrimaryKey', 'Codaluno'), $comparison);
        } else {
            throw new PropelException('filterByAluno() only accepts arguments of type \App\App\Aluno or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Aluno relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function joinAluno($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @return \App\App\AlunoQuery A secondary query class using the current class as primary query
     */
    public function useAlunoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAluno($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Aluno', '\App\App\AlunoQuery');
    }

    /**
     * Filter the query by a related \App\App\Professor object
     *
     * @param \App\App\Professor|ObjectCollection $professor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByProfessor($professor, $comparison = null)
    {
        if ($professor instanceof \App\App\Professor) {
            return $this
                ->addUsingAlias(TrabalhoTableMap::COL_CODPROFESSOR, $professor->getCodprofessor(), $comparison);
        } elseif ($professor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TrabalhoTableMap::COL_CODPROFESSOR, $professor->toKeyValue('PrimaryKey', 'Codprofessor'), $comparison);
        } else {
            throw new PropelException('filterByProfessor() only accepts arguments of type \App\App\Professor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Professor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function joinProfessor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @return \App\App\ProfessorQuery A secondary query class using the current class as primary query
     */
    public function useProfessorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProfessor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Professor', '\App\App\ProfessorQuery');
    }

    /**
     * Filter the query by a related \App\App\Versao object
     *
     * @param \App\App\Versao|ObjectCollection $versao the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTrabalhoQuery The current query, for fluid interface
     */
    public function filterByVersao($versao, $comparison = null)
    {
        if ($versao instanceof \App\App\Versao) {
            return $this
                ->addUsingAlias(TrabalhoTableMap::COL_CODTRABALHO, $versao->getCodtrabalho(), $comparison);
        } elseif ($versao instanceof ObjectCollection) {
            return $this
                ->useVersaoQuery()
                ->filterByPrimaryKeys($versao->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVersao() only accepts arguments of type \App\App\Versao or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Versao relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function joinVersao($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Versao');

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
            $this->addJoinObject($join, 'Versao');
        }

        return $this;
    }

    /**
     * Use the Versao relation Versao object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\App\VersaoQuery A secondary query class using the current class as primary query
     */
    public function useVersaoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVersao($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Versao', '\App\App\VersaoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTrabalho $trabalho Object to remove from the list of results
     *
     * @return $this|ChildTrabalhoQuery The current query, for fluid interface
     */
    public function prune($trabalho = null)
    {
        if ($trabalho) {
            $this->addUsingAlias(TrabalhoTableMap::COL_CODTRABALHO, $trabalho->getCodtrabalho(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the trabalho table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrabalhoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TrabalhoTableMap::clearInstancePool();
            TrabalhoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TrabalhoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TrabalhoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TrabalhoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TrabalhoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TrabalhoQuery
