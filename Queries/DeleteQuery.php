<?php

/**
 * DeleteQuery class file
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
 * DeleteQuery class
 *
 * Returns a delete query 
 *    - DELETE $table WHERE $pk = :$pk
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class DeleteQuery implements Query
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

    public function query($row=array())
    {
        if (empty($this->table)) {
            throw new QueryException("Table name property cannot be empty");
        }
        if (empty($this->pk)) {
            throw new QueryException("Primary key property cannot be empty");
        }
        if (empty($this->origin)) {
            throw new QueryException("Origin query object cannot be empty");
        }
        return  "DELETE FROM {$this->table} WHERE {$this->pk} = :{$this->pk}";
    }

}