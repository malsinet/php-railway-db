<?php

/**
 * FilteredQuery class file
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
 * FilteredQuery class
 *
 * Returns a filtered query ("WHERE $field = '$value'")
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class FilteredQuery implements Query;
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
        $query = $this->origin->query($row);
        if (preg_match("/ WHERE /i")) {
            $query.= "AND ({$field} = '{$value}')"; 
        } else {
            $query.= "WHERE ({$field} = '{$value}')"; 
        }
        return $query;
    }

}