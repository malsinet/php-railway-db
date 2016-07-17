<?php

/**
 * BaseQuery class file
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
 * BaseQuery class
 *
 * BaseQuery returns an empty query 
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class Base implements Query
{

    public $table;

    public $pk;
    
    public $row;
    
    public function __construct($table, $pk, $row)
    {
        $this->table = $table;
        $this->pk    = $pk;
        $this->row   = $row;
    }

    public function query($row=array())
    {
        return "";
    }

}