<?php

/**
 * CRUD interface file
 *
 * @category   Contracts
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Contracts;


/**
 * CRUD interface
 *
 * Methods to perform Create, Read, Update, Delete & Find on a table
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
interface CRUD
{
    public function insertRow($row);

    public function selectRows($conditions);

    public function selectCount($conditions);

    public function findRowByFields($matches);

    public function updateRow($row);

    public function deleteRow($row);
}