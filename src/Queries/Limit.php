<?php

/**
 * Limit class file
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
 * Limit class
 *
 * Returns an ORDER BY clause
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class Limit implements Query
{
    private $origin;

    private $limit;

    private $offset;
    
    public $table;

    public $pk;
    
    public $row;
    
    public function __construct($origin, $limit, $offset)
    {
        $this->origin = $origin;
        $this->table  = $origin->table;
        $this->pk     = $origin->pk;
        $this->row    = $origin->row;
        $this->limit  = $limit;
        $this->offset = $offset;
    }

    public function query($row=null)
    {
        if (empty($this->origin)) {
            throw new QueryException("Origin query object cannot be empty");
        }
        if (empty($this->limit)) {
            throw new QueryException("Limit parameter cannot be empty");
        }
        if (empty($this->offset)) {
            throw new QueryException("Offset parameter cannot be empty");
        }
        return $this->origin->query($row).
               " LIMIT {$this->limit} OFFSET {$this->offset}";
    }

}