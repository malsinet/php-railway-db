<?php

/**
 * PdoTable class file
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
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
 * @author     Martin Alsinet <martin@alsinet>
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
     * @return generator
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
     * Select one page of rows matching fields/values
     *
     * @param integer $page        Page number
     * @param integer $rowsPerPage Page size
     * @param array   $fields      Fields array
     * @return array
     */
    public function selectPage($page, $rowsPerPage, $fields=array())
    {
        if (!is_array($fields)) {
            throw new DatabaseException(
                "Fields parameter [$fields] must be an array"
            );
        }
        try {
            $limit  = intval($rowsPerPage);
            $offset = intval(($page - 1) * $rowsPerPage);
            $subqry = $this->queries->selectRows($fields);
            $query  = "SELECT * FROM ($subqry) as t LIMIT $limit OFFSET $offset";
            $stmt   = $this->db->prepare($query);
            $binds  = $this->row->toBinds($fields);
            $binds  = !empty($binds) ? $binds : null;
            $stmt->execute($binds);
            $rows   = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $rowcount = $this->selectCount($fields);
            $page     = $this->pagination($page, $rowsPerPage, $rowcount);
            $page["rows"] = $rows;
            return $page;
        } catch (\PDOException $ex) {
            throw new DatabaseException($ex->getMessage(), 0, $ex);
        }
    }

    /**
     * Select Count of rows matching fields/values
     *
     * @param array $fields Fields array
     * @return array
     */
    public function selectCount($fields=array())
    {
        if (!is_array($fields)) {
            throw new DatabaseException(
                "Fields parameter [$fields] must be an array"
            );
        }
        try {
            $query = $this->queries->selectCount($fields);
            $stmt  = $this->db->prepare($query);
            $binds = $this->row->toBinds($fields);
            $binds = !empty($binds) ? $binds : null;
            $stmt->execute($binds);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            return intval($row["rowcount"]);
        } catch (\PDOException $ex) {
            throw new DatabaseException($ex->getMessage(), 0, $ex);
        }
    }

    /**
     * Perform pagination calculations
     *
     * @param integer $page        Current page
     * @param integer $rowsPerPage Rows per page
     * @return array
     */
    public function pagination($page, $rowsPerPage, $totalRows)
    {
        $totalPages = intval(ceil($totalRows/$rowsPerPage));
        $page       = ($page>$totalPages) ? $totalPages : $page;
        $page       = ($page<1) ? 1 : $page;
        $nextPage   = ($page+1>$totalPages) ? $totalPages : $page+1;
        $prevPage   = ($page-1<1) ? 1 : $page-1;
        $firstRow   = $rowsPerPage * ($page-1) + 1;
        $lastRow    = ($page == $totalPages) ? $totalRows : $firstRow + $rowsPerPage - 1;
        $ret = array(
            "page"          => $page,
            "next_page"     => $nextPage,
            "prev_page"     => $prevPage,
            "first_page"    => 1,
            "last_page"     => $totalPages,
            "first_row"     => $firstRow,
            "last_row"      => $lastRow,
            "rows_per_page" => $rowsPerPage,
            "total_rows"    => $totalRows,
            "total_pages"   => $totalPages,
            "rows"          => array()
        );
        return $ret;
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