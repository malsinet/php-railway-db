<?php

/**
 * Exclusion class file
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
 * Exclusion class
 *
 * Returns an exclusion clause ("WHERE $field <> :$field")
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class Exclusion implements Query
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
        if (empty($this->field)) {
            throw new QueryException("Exclusion field property cannot be empty");
        }
        if (empty($this->value)) {
            throw new QueryException("Exclusion value property cannot be empty");
        }
        $query = $this->origin->query($row);
        if (preg_match("/ WHERE /i", $query)) {
            $query.= " AND ({$this->field} <> '{$this->value}')"; 
        } else {
            $query.= " WHERE ({$this->field} <> '{$this->value}')"; 
        }
        return $query;
    }

}