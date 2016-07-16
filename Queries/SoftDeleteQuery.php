<?php

/**
 * SoftDeleteQuery class file
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

use github\malsinet\Database\Contracts\Query;


/**
 * SoftDeleteQuery class
 *
 * Returns a soft delete query 
 *   - UPDATE $table SET $field = 'DELETED' WHERE $pk = :$pk
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class SoftDeleteQuery implements Query;
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

    public function query($row)
    {
        return "UPDATE {$this->table} SET {$this->field} = '{$this->value}'  WHERE {$this->pk} = :{$this->pk}";
    }

}