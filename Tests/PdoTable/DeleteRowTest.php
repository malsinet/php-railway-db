<?php

/**
 * DeleteRowTest class file
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Tests\PdoTable;

use PHPUnit\Framework\TestCase;
use github\malsinet\Railway\Database as DB;


/**
 * DeleteRowTest class
 *
 * Tests checking ::deleteRow
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class DeleteRowTest extends TestCase
{

    public function setUp()
    {
        $this->db = new \PDO('sqlite::memory:');
        $this->db->setAttribute(
            \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
        );
        $this->db->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT, age INTEGER)");
        $this->db->exec("INSERT INTO users (name, age) VALUES ('Axl', 50)");
        $this->db->exec("INSERT INTO users (name, age) VALUES ('Slash', 51)");
        $this->db->exec("INSERT INTO users (name, age) VALUES ('Duff', 52)");
        $this->db->exec("INSERT INTO users (name, age) VALUES ('Izzy', 53)");
        $this->db->exec("INSERT INTO users (name, age) VALUES ('Steven', 54)");
        
        $this->table = new DB\PdoTable(
            $this->db,
            new DB\TableQueries(
                $insert=null, 
                $select=null,
                $find=null,
                $update=null,
                new DB\Queries\Delete(
                    new DB\Queries\Base(
                        $table="users", $pk="id", new DB\RowToQuery()
                    )
                )
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
        $this->table->findRowByFields("this is a string");
    }
    
	public function testDeleteRow()
	{
        $fields   = array("id" => 2);
        $this->table->deleteRow($fields);

        $query = "SELECT * FROM users";
        $sth = $this->db->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        $expected = array(
            array("id" => 1, "name" => "Axl", "age" => 50),
            array("id" => 3, "name" => "Duff", "age" => 52),
            array("id" => 4, "name" => "Izzy", "age" => 53),
            array("id" => 5, "name" => "Steven", "age" => 54)
        );
        $this->assertEquals($expected, $result, "Should delete one row");
    }

	public function testCantDeleteRowWithoutIdField()
	{
        $fields = array("name" => "Axl");
        $this->expectException(DB\DatabaseException::class);
        $this->table->deleteRow($fields);
    }

}