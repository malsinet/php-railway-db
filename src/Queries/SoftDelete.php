<?php

/**
 * SoftDelete class file
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
 * SoftDelete class
 *
 * Returns a soft delete query 
 *   - UPDATE $table SET $field = 'DELETED' WHERE $pk = :$pk
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class SoftDelete implements Query
{
    private $origin;

    private $field;

    private $value;
    
    public $table;

    public $pk;
    
    public $row;
    
    public function __construct($origin, $field, $value)
    {
        $this->origin = $origin;
        $this->table  = $origin->table;
        $this->pk     = $origin->pk;
        $this->row    = $origin->row;
        $this->field  = $field;
        $this->value  = $value;
    }

    public function query($row=array())
    {
        if (empty($this->origin)) {
            throw new QueryException("Origin query object cannot be empty");
        }
        if (empty($this->table)) {
            throw new QueryException("Query table property cannot be empty");
        }
        if (empty($this->pk)) {
            throw new QueryException("Query pk property cannot be empty");
        }
        if (empty($this->field)) {
            throw new QueryException("Query field property cannot be empty");
        }
        if (empty($this->value)) {
            throw new QueryException("Query value property cannot be empty");
        }
        return "UPDATE {$this->table} SET {$this->field} = '{$this->value}' WHERE ({$this->pk} = :{$this->pk})";
    }

}