<?php

/**
 * FindRowByFieldsTest class file
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
 * FindRowByFieldsTest class
 *
 * Tests checking  findRowByFields
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class FindRowByFieldsTest extends TestCase
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
                new DB\Queries\Find(
                    new DB\Queries\Base(
                        $table="users", $pk="id", new DB\RowToQuery()
                    )
                ),
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
        $this->table->findRowByFields($fields=null);
    }
    
	public function testNotArrayFieldsParameterThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->findRowByFields(555);
    }
    
	public function testFindRowByOneField()
	{
        $expected = array("id" => 2, "name" => "Slash", "age" => 51);
        $fields   = array("id" => 2);
        $this->assertEquals(
            $expected,
            $this->table->findRowByFields($fields),
            "Should Find one row"
        );
    }

	public function testFindRowByTwoFields()
	{
        $expected = array("id" => 1, "name" => "Axl", "age" => 50);
        $fields   = array("id" => 1, "name" => "Axl");
        $this->assertEquals(
            $expected,
            $this->table->findRowByFields($fields),
            "Should Find one row"
        );
    }

	public function testFindRowByFieldsNotFound()
	{
        $fields = array("id" => 1, "name" => "Lars");
        $this->assertEquals(
            false,
            $this->table->findRowByFields($fields),
            "Should not find an inexistent row"
        );
        
    }
    
}