<?php

/**
 * Row interface
 *
 * @category   Contracts
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Contracts;


/**
 * Row interface
 *
 * Methods to transform row arrays to Query snippets
 *
 * @category   Contracts
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
interface Row;
{
    public function toFields($row);
    
    public function toValues($row);
    
    public function toPredicates($row);

    public function toBinds($row);

    public function toUpdate($row, $idField);
}