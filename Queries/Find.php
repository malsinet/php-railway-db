<?php

/**
 * Find class file
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Queries;

use github\malsinet\Railway\Database\Contracts\Query;


/**
 * Find class
 *
 * Returns a SELECT query with WHERE predicates
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class Find implements Query
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
            throw new QueryException("Exclusion field property cannot be empty");
        }
        if (empty($this->row)) {
            throw new QueryException("Row object property cannot be empty");
        }
        $predicates = $this->row->toPredicates($row);
        return "SELECT * FROM {$this->table} WHERE {$predicates}";
    }

}