<?php

/**
 * CompositeQuery class file
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
 * CompositeKey class
 *
 * Returns a query decorated with a WHERE clause for composite keys 
 *    - WHERE ($pk_1 = :$pk_1) AND ($pk_2 = :$pk2)
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class CompositeKey implements Query
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
        if (empty($this->origin)) {
            throw new QueryException("Origin query object cannot be empty");
        }        
        if (empty($this->pk)) {
            throw new QueryException("Primary key property cannot be empty");
        }
        if (!is_array($this->pk)) {
            throw new QueryException(
                "Primary key must be an array for composite queries"
            );
        }
        $clause = "";
        foreach ($this->pk as $field) {
            $clause .= " ({$field} = :$field) AND";
        }
        $clause = preg_replace("/ AND$/", "", $clause);
        $clause = " WHERE".$clause;
        $query = str_replace(
            'WHERE (Array = :Array)',
            $clause,
            $this->origin->query($row)
        );
        return $query;
    }

}