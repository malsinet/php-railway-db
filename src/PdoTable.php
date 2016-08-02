<?php

/**
 * PdoTable class file
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database;


/**
 * PdoTable class
 *
 * Class to Execute CRUD operations on a PDO table
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class PdoTable implements Contracts\CRUD
{
    /**
     * PDO database object
     *
     * @var \PDO
     */
    private $db;

    /**
     * TableQueries object
     *
     * @var TableQueries
     */
    private $queries;

    /**
     * RowToQuery object
     *
     * @var RowToQuery
     */
    private $row;
    
    /**
     * Class constructor
     *
     * @param \PDO         $db      Database link
     * @param TableQueries $queries CRUD table queries
     * @param RowToQuery   $row     RowToQuery object
     */
    public function __construct(\PDO $db, Contracts\CRUD $queries, Contracts\Row $row)
    {
        $this->db      = $db;
        $this->queries = $queries;
        $this->row     = $row;
    }

    /**
     * Insert a row
     * Returns the record inserted id
     *
     * @param array $fields Row fields
     * @return int
     */
    public function insertRow($fields)
    {
        if (!is_array($fields)) {
            throw new DatabaseException(
                "Fields parameter [$fields] must be an array"
            );
        }
        try {
            $query = $this->queries->insertRow($fields);
            $stmt  = $this->db->prepare($query);
            $binds = $this->row->toBinds($fields);
            $retcode = $stmt->execute($binds);
            return $this->db->lastInsertId();
        } catch (\PDOException $ex) {
            throw new DatabaseException($ex->getMessage(), 0, $ex);
        }
    }

    /**
     * Select rows matching fields/values
     *
     * @param array $fields Fields array
     * @return array
     */
    public function selectRows($fields=array())
    {
        if (!is_array($fields)) {
            throw new DatabaseException(
                "Fields parameter [$fields] must be an array"
            );
        }
        try {
            $query = $this->queries->selectRows($fields);
            $stmt  = $this->db->prepare($query);
            $binds = $this->row->toBinds($fields);
            // limit & offset parameters must be bound as INT
            foreach ($binds as $bind => $value) {
                if ($bind == ":limit") {
                    $stmt->bindParam(
                        $bind, $value, \PDO::PARAM_INT
                    );
                    unset($binds[$bind]);
                }
                if ($bind == ":offset") {
                    $stmt->bindParam(
                        $bind, $value, \PDO::PARAM_INT
                    );
                    unset($binds[$bind]);
                }
            }
            $binds = !empty($binds) ? $binds : null;
             $stmt->execute($binds);
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                yield $row;
            }
        } catch (\PDOException $ex) {
            throw new DatabaseException($ex->getMessage(), 0, $ex);
        }
    }

    /**
     * Find one row matching fields/values
     *
     * @param array $fields Fields array
     * @return array
     */
    public function findRowByFields($fields)
    {
        if (!is_array($fields)) {
            throw new DatabaseException(
                "Fields parameter [$fields] must be an array"
            );
        }
        try {
            $query = $this->queries->findRowByFields($fields);
            $stmt  = $this->db->prepare($query);
            $binds = $this->row->toBinds($fields);
            $stmt->execute($binds);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $row;
        } catch (\PDOException $ex) {
            throw new DatabaseException($ex->getMessage(), 0, $ex);
        }
    }

    /**
     * Update one row
     *
     * @param array $fields Updated fields
     */
    public function updateRow($fields)
    {
        if (!is_array($fields)) {
            throw new DatabaseException(
                "Fields parameter [$fields] must be an array"
            );
        }
        try {
            $query = $this->queries->updateRow($fields);
            $stmt  = $this->db->prepare($query);
            $binds = $this->row->toBinds($fields);
            $stmt->execute($binds);
            return;
        } catch (\PDOException $ex) {
            throw new DatabaseException($ex->getMessage(), 0, $ex);
        }
    }

    /**
     * Delete one row
     *
     * @param array $fields Updated fields
     */
    public function deleteRow($fields)
    {
        if (!is_array($fields)) {
            throw new DatabaseException(
                "Fields parameter [$fields] must be an array"
            );
        }
        try {
            $query = $this->queries->deleteRow($fields);        
            $stmt  = $this->db->prepare($query);
            $binds = $this->row->toBinds($fields);
            $stmt->execute($binds);
            return;
        } catch (\PDOException $ex) {
            throw new DatabaseException($ex->getMessage(), 0, $ex);
        }
    }

}