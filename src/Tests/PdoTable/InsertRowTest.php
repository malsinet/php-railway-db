<?php

/**
 * InsertRowTest class file
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Tests\PdoTable;

use PHPUnit\Framework\TestCase;
use github\malsinet\Railway\Database as DB;


/**
 * InsertRowTest class
 *
 * Tests checking  insertRow
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class InsertRowTest extends TestCase
{

    public function setUp()
    {
        $this->db = new \PDO('sqlite::memory:');
        $this->db->setAttribute(
            \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
        );
        $this->db->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT, age INTEGER)");
        $this->table = new DB\PdoTable(
            $this->db,
            new DB\TableQueries(
                new DB\Queries\Insert(
                    new DB\Queries\Base(
                        $table="users", $pk="id", new DB\RowToQuery()
                    )
                ),
                $select=null,
                $find=null,
                $update=null,
                $delete=null
            ),
            new DB\RowToQuery()
        );
    }

    public function tearDown()
    {
        $this->table = null;
        $this->db = null;
    }
    
	public function testEmptyFieldsParameterThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->insertRow($fields=null);
    }
    
	public function testInsertRow()
	{
        $rows = array(
            array("name" => "John", "age" => 70),
            array("name" => "Paul", "age" => 69),
            array("name" => "George", "age" => 68),
            array("name" => "Ringo", "age" => 67)
        );
        foreach ($rows as $row) {
            $this->table->insertRow($row);
        }
        $query = "SELECT name, age FROM users";
        $sth = $this->db->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        $this->assertEquals($rows, $result, "Should insert 4 rows");
        
    }

}