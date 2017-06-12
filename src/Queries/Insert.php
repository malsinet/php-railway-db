<?php

/**
 * Insert class file
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Queries;

use github\malsinet\Railway\Database\Contracts\Query;


/**
 * Insert class
 *
 * Returns an INSERT query 
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class Insert implements Query
{
    private $origin;

    public $table;

    public $pk;
    
    public $row;
    
    public function __construct($origin)
    {
        $this->origin = $origin;
        $this->table  = $origin->table;
        $this->pk     = $origin->pk;
        $this->row    = $origin->row;
    }

    public function query($row)
    {
        if (empty($this->origin)) {
            throw new QueryException("Origin query object cannot be empty");
        }
        if (empty($this->table)) {
            throw new QueryException("Query table property cannot be empty");
        }
        if (empty($this->row)) {
            throw new QueryException("Query row property cannot be empty");
        }
        $fields = $this->row->toFields($row);
        $values = $this->row->toValues($row);
        return "INSERT INTO {$this->table} ({$fields}) VALUES ({$values})";
    }

}