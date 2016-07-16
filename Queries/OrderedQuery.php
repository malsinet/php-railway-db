<?php

/**
 * OrderedQuery class file
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
 * OrderedQuery class
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
final class OrderedQuery implements Query;
{
    private $origin;

    private $field;

    private $direction;
    
    public $table;

    public $pk;
    
    public $row;
    
    public function __construct($origin, $field, $direction)
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
        return $this->origin->query($row)." ORDER BY {$this->field} {$this->direction}";
    }

}