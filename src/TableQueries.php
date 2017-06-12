<?php

/**
 * RowToQuery class file
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database;


/**
 * RowToQuery class
 *
 * Methods to transform row arrays to Query snippets
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class TableQueries implements Contracts\CRUD
{

    private $insert;
    
    private $select;
    
    private $find;
    
    private $update;

    private $delete;

    public function __construct($insert, $select, $find, $update, $delete)
    {
        $this->insert = $insert;
        $this->select = $select;
        $this->find   = $find;
        $this->update = $update;
        $this->delete = $delete;
    }

    public function insertRow($row)
    {
        return $this->insert->query($row);
    }

    public function selectRows($matches)
    {
        return $this->select->query($matches);
    }

    public function findRowByFields($matches)
    {
        return $this->find->query($matches);
    }

    public function updateRow($row)
    {
        return $this->update->query($row);
    }

    public function deleteRow($row)
    {
        return $this->delete->query($row);
    }

}
