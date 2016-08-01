<?php

/**
 * OrderBy class file
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
 * OrderBy class
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
final class OrderBy implements Query
{
    private $origin;

    private $field;

    private $direction;
    
    public $table;

    public $pk;
    
    public $row;
    
    public function __construct($origin, $field, $direction)
    {
        $this->origin    = $origin;
        $this->table     = $origin->table;
        $this->pk        = $origin->pk;
        $this->row       = $origin->row;
        $this->field     = $field;
        $this->direction = $direction;
    }

    public function query($row=null)
    {
        if (empty($this->origin)) {
            throw new QueryException("Origin query object cannot be empty");
        }
        if (empty($this->field)) {
            throw new QueryException("OrderBy field property cannot be empty");
        }
        if (empty($this->direction)) {
            throw new QueryException(
                "OrderBy direction property cannot be empty"
            );
        }
        return $this->origin->query($row).
               " ORDER BY {$this->field} {$this->direction}";
    }

}