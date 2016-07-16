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

    private $db;

    private $queries;

    private $row;
    
    public function __construct(\PDO $db, Contracts\CRUD $queries)
    {
        $this->db      = $db;
        $this->queries = $queries;
        $this->row     = $row;
    }

    public function insertRow($row)
    {
        $query = $this->queries->insertRow($row);
        $stmt  = $this->db->prepare($query);
        $binds = $this->row->toBinds($row);
        $stmt->execute($binds);
        return $this->db->lastInsertId();
    }

    public function selectRows($fields=array())
    {
        $query = $this->queries->selectRows($fields);
        $stmt  = $this->db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            yield $row;
        }
    }

    public function findRowByFields($fields)
    {
        $query = $this->queries->findRowByFields($fields);
        $stmt  = $this->db->prepare($query);
        $binds = $this->row->toBinds($fields);
        $stmt->execute($binds);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }

    public function updateRow($row)
    {
        $query = $this->queries->updateRow($row);
        $stmt  = $this->db->prepare($query);
        $binds = $this->row->toBinds($row);
        $stmt->execute($binds);
        return;
    }

    public function deleteRow($row)
    {
        $query = $this->queries->deleteRow($row);
        $stmt  = $this->db->prepare($query);
        $binds = $this->row->toBinds($row);
        $stmt->execute($binds);
        return;
    }

}