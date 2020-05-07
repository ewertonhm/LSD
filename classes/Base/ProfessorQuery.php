<?php

namespace Base;

use \Professor as ChildProfessor;
use \ProfessorQuery as ChildProfessorQuery;
use \Exception;
use \PDO;
use Map\ProfessorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'professor' table.
 *
 *
 *
 * @method     ChildProfessorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProfessorQuery orderByNome($order = Criteria::ASC) Order by the nome column
 * @method     ChildProfessorQuery orderByEndereco($order = Criteria::ASC) Order by the endereco column
 * @method     ChildProfessorQuery orderByTelefone($order = Criteria::ASC) Order by the telefone column
 * @method     ChildProfessorQuery orderByUsuarioId($order = Criteria::ASC) Order by the usuario_id column
 * @method     ChildProfessorQuery orderByCursoId($order = Criteria::ASC) Order by the curso_id column
 *
 * @method     ChildProfessorQuery groupById() Group by the id column
 * @method     ChildProfessorQuery groupByNome() Group by the nome column
 * @method     ChildProfessorQuery groupByEndereco() Group by the endereco column
 * @method     ChildProfessorQuery groupByTelefone() Group by the telefone column
 * @method     ChildProfessorQuery groupByUsuarioId() Group by the usuario_id column
 * @method     ChildProfessorQuery groupByCursoId() Group by the curso_id column
 *
 * @method     ChildProfessorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProfessorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProfessorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProfessorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildProfessorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildProfessorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildProfessorQuery leftJoinCurso($relationAlias = null) Adds a LEFT JOIN clause to the query using the Curso relation
 * @method     ChildProfessorQuery rightJoinCurso($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Curso relation
 * @method     ChildProfessorQuery innerJoinCurso($relationAlias = null) Adds a INNER JOIN clause to the query using the Curso relation
 *
 * @method     ChildProfessorQuery joinWithCurso($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Curso relation
 *
 * @method     ChildProfessorQuery leftJoinWithCurso() Adds a LEFT JOIN clause and with to the query using the Curso relation
 * @method     ChildProfessorQuery rightJoinWithCurso() Adds a RIGHT JOIN clause and with to the query using the Curso relation
 * @method     ChildProfessorQuery innerJoinWithCurso() Adds a INNER JOIN clause and with to the query using the Curso relation
 *
 * @method     ChildProfessorQuery leftJoinUsuario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Usuario relation
 * @method     ChildProfessorQuery rightJoinUsuario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Usuario relation
 * @method     ChildProfessorQuery innerJoinUsuario($relationAlias = null) Adds a INNER JOIN clause to the query using the Usuario relation
 *
 * @method     ChildProfessorQuery joinWithUsuario($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Usuario relation
 *
 * @method     ChildProfessorQuery leftJoinWithUsuario() Adds a LEFT JOIN clause and with to the query using the Usuario relation
 * @method     ChildProfessorQuery rightJoinWithUsuario() Adds a RIGHT JOIN clause and with to the query using the Usuario relation
 * @method     ChildProfessorQuery innerJoinWithUsuario() Adds a INNER JOIN clause and with to the query using the Usuario relation
 *
 * @method     ChildProfessorQuery leftJoinTrabalho($relationAlias = null) Adds a LEFT JOIN clause to the query using the Trabalho relation
 * @method     ChildProfessorQuery rightJoinTrabalho($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Trabalho relation
 * @method     ChildProfessorQuery innerJoinTrabalho($relationAlias = null) Adds a INNER JOIN clause to the query using the Trabalho relation
 *
 * @method     ChildProfessorQuery joinWithTrabalho($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Trabalho relation
 *
 * @method     ChildProfessorQuery leftJoinWithTrabalho() Adds a LEFT JOIN clause and with to the query using the Trabalho relation
 * @method     ChildProfessorQuery rightJoinWithTrabalho() Adds a RIGHT JOIN clause and with to the query using the Trabalho relation
 * @method     ChildProfessorQuery innerJoinWithTrabalho() Adds a INNER JOIN clause and with to the query using the Trabalho relation
 *
 * @method     \CursoQuery|\UsuarioQuery|\TrabalhoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProfessor findOne(ConnectionInterface $con = null) Return the first ChildProfessor matching the query
 * @method     ChildProfessor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProfessor matching the query, or a new ChildProfessor object populated from the query conditions when no match is found
 *
 * @method     ChildProfessor findOneById(int $id) Return the first ChildProfessor filtered by the id column
 * @method     ChildProfessor findOneByNome(string $nome) Return the first ChildProfessor filtered by the nome column
 * @method     ChildProfessor findOneByEndereco(string $endereco) Return the first ChildProfessor filtered by the endereco column
 * @method     ChildProfessor findOneByTelefone(string $telefone) Return the first ChildProfessor filtered by the telefone column
 * @method     ChildProfessor findOneByUsuarioId(int $usuario_id) Return the first ChildProfessor filtered by the usuario_id column
 * @method     ChildProfessor findOneByCursoId(int $curso_id) Return the first ChildProfessor filtered by the curso_id column *

 * @method     ChildProfessor requirePk($key, ConnectionInterface $con = null) Return the ChildProfessor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProfessor requireOne(ConnectionInterface $con = null) Return the first ChildProfessor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProfessor requireOneById(int $id) Return the first ChildProfessor filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProfessor requireOneByNome(string $nome) Return the first ChildProfessor filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProfessor requireOneByEndereco(string $endereco) Return the first ChildProfessor filtered by the endereco column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProfessor requireOneByTelefone(string $telefone) Return the first ChildProfessor filtered by the telefone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProfessor requireOneByUsuarioId(int $usuario_id) Return the first ChildProfessor filtered by the usuario_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProfessor requireOneByCursoId(int $curso_id) Return the first ChildProfessor filtered by the curso_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProfessor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProfessor objects based on current ModelCriteria
 * @method     ChildProfessor[]|ObjectCollection findById(int $id) Return ChildProfessor objects filtered by the id column
 * @method     ChildProfessor[]|ObjectCollection findByNome(string $nome) Return ChildProfessor objects filtered by the nome column
 * @method     ChildProfessor[]|ObjectCollection findByEndereco(string $endereco) Return ChildProfessor objects filtered by the endereco column
 * @method     ChildProfessor[]|ObjectCollection findByTelefone(string $telefone) Return ChildProfessor objects filtered by the telefone column
 * @method     ChildProfessor[]|ObjectCollection findByUsuarioId(int $usuario_id) Return ChildProfessor objects filtered by the usuario_id column
 * @method     ChildProfessor[]|ObjectCollection findByCursoId(int $curso_id) Return ChildProfessor objects filtered by the curso_id column
 * @method     ChildProfessor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProfessorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ProfessorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Professor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProfessorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProfessorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProfessorQuery) {
            return $criteria;
        }
        $query = new ChildProfessorQuery();
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
     * @return ChildProfessor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProfessorTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ProfessorTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildProfessor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nome, endereco, telefone, usuario_id, curso_id FROM professor WHERE id = :p0';
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
            /** @var ChildProfessor $obj */
            $obj = new ChildProfessor();
            $obj->hydrate($row);
            ProfessorTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildProfessor|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProfessorTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProfessorTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProfessorTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProfessorTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfessorTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfessorTableMap::COL_NOME, $nome, $comparison);
    }

    /**
     * Filter the query on the endereco column
     *
     * Example usage:
     * <code>
     * $query->filterByEndereco('fooValue');   // WHERE endereco = 'fooValue'
     * $query->filterByEndereco('%fooValue%', Criteria::LIKE); // WHERE endereco LIKE '%fooValue%'
     * </code>
     *
     * @param     string $endereco The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByEndereco($endereco = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($endereco)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfessorTableMap::COL_ENDERECO, $endereco, $comparison);
    }

    /**
     * Filter the query on the telefone column
     *
     * Example usage:
     * <code>
     * $query->filterByTelefone('fooValue');   // WHERE telefone = 'fooValue'
     * $query->filterByTelefone('%fooValue%', Criteria::LIKE); // WHERE telefone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telefone The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByTelefone($telefone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telefone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfessorTableMap::COL_TELEFONE, $telefone, $comparison);
    }

    /**
     * Filter the query on the usuario_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUsuarioId(1234); // WHERE usuario_id = 1234
     * $query->filterByUsuarioId(array(12, 34)); // WHERE usuario_id IN (12, 34)
     * $query->filterByUsuarioId(array('min' => 12)); // WHERE usuario_id > 12
     * </code>
     *
     * @see       filterByUsuario()
     *
     * @param     mixed $usuarioId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByUsuarioId($usuarioId = null, $comparison = null)
    {
        if (is_array($usuarioId)) {
            $useMinMax = false;
            if (isset($usuarioId['min'])) {
                $this->addUsingAlias(ProfessorTableMap::COL_USUARIO_ID, $usuarioId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usuarioId['max'])) {
                $this->addUsingAlias(ProfessorTableMap::COL_USUARIO_ID, $usuarioId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfessorTableMap::COL_USUARIO_ID, $usuarioId, $comparison);
    }

    /**
     * Filter the query on the curso_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCursoId(1234); // WHERE curso_id = 1234
     * $query->filterByCursoId(array(12, 34)); // WHERE curso_id IN (12, 34)
     * $query->filterByCursoId(array('min' => 12)); // WHERE curso_id > 12
     * </code>
     *
     * @see       filterByCurso()
     *
     * @param     mixed $cursoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByCursoId($cursoId = null, $comparison = null)
    {
        if (is_array($cursoId)) {
            $useMinMax = false;
            if (isset($cursoId['min'])) {
                $this->addUsingAlias(ProfessorTableMap::COL_CURSO_ID, $cursoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cursoId['max'])) {
                $this->addUsingAlias(ProfessorTableMap::COL_CURSO_ID, $cursoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfessorTableMap::COL_CURSO_ID, $cursoId, $comparison);
    }

    /**
     * Filter the query by a related \Curso object
     *
     * @param \Curso|ObjectCollection $curso The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByCurso($curso, $comparison = null)
    {
        if ($curso instanceof \Curso) {
            return $this
                ->addUsingAlias(ProfessorTableMap::COL_CURSO_ID, $curso->getId(), $comparison);
        } elseif ($curso instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProfessorTableMap::COL_CURSO_ID, $curso->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCurso() only accepts arguments of type \Curso or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Curso relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function joinCurso($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Curso');

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
            $this->addJoinObject($join, 'Curso');
        }

        return $this;
    }

    /**
     * Use the Curso relation Curso object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CursoQuery A secondary query class using the current class as primary query
     */
    public function useCursoQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCurso($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Curso', '\CursoQuery');
    }

    /**
     * Filter the query by a related \Usuario object
     *
     * @param \Usuario|ObjectCollection $usuario The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = null)
    {
        if ($usuario instanceof \Usuario) {
            return $this
                ->addUsingAlias(ProfessorTableMap::COL_USUARIO_ID, $usuario->getId(), $comparison);
        } elseif ($usuario instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProfessorTableMap::COL_USUARIO_ID, $usuario->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUsuario() only accepts arguments of type \Usuario or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Usuario relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function joinUsuario($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Usuario');

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
            $this->addJoinObject($join, 'Usuario');
        }

        return $this;
    }

    /**
     * Use the Usuario relation Usuario object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsuarioQuery A secondary query class using the current class as primary query
     */
    public function useUsuarioQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUsuario($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Usuario', '\UsuarioQuery');
    }

    /**
     * Filter the query by a related \Trabalho object
     *
     * @param \Trabalho|ObjectCollection $trabalho the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProfessorQuery The current query, for fluid interface
     */
    public function filterByTrabalho($trabalho, $comparison = null)
    {
        if ($trabalho instanceof \Trabalho) {
            return $this
                ->addUsingAlias(ProfessorTableMap::COL_ID, $trabalho->getProfessorId(), $comparison);
        } elseif ($trabalho instanceof ObjectCollection) {
            return $this
                ->useTrabalhoQuery()
                ->filterByPrimaryKeys($trabalho->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTrabalho() only accepts arguments of type \Trabalho or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Trabalho relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function joinTrabalho($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
     * @return \TrabalhoQuery A secondary query class using the current class as primary query
     */
    public function useTrabalhoQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTrabalho($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Trabalho', '\TrabalhoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProfessor $professor Object to remove from the list of results
     *
     * @return $this|ChildProfessorQuery The current query, for fluid interface
     */
    public function prune($professor = null)
    {
        if ($professor) {
            $this->addUsingAlias(ProfessorTableMap::COL_ID, $professor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the professor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProfessorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProfessorTableMap::clearInstancePool();
            ProfessorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProfessorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProfessorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProfessorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProfessorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProfessorQuery
