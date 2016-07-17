<?php

/**
 * PdoTableSelectRowsTest class file
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Tests;

use PHPUnit\Framework\TestCase;
use github\malsinet\Railway\Database as DB;


/**
 * PdoTableSelectRowsTest class
 *
 * Tests checking PdoTable insertRow
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class PdoTableSelectRowsTest extends TestCase
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
                new DB\Queries\SelectAll(
                    new DB\Queries\Base(
                        $table="users", $pk="id", new DB\RowToQuery()
                    )
                ),
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
        foreach ($this->table->selectRows("this is a string") as $row) {
            
        };
    }
    
	public function testSelectRows()
	{
        $expected = array(
            array("id" => 1, "name" => "Axl", "age" => 50),
            array("id" => 2, "name" => "Slash", "age" => 51),
            array("id" => 3, "name" => "Duff", "age" => 52),
            array("id" => 4, "name" => "Izzy", "age" => 53),
            array("id" => 5, "name" => "Steven", "age" => 54)
        );
        $result = array();
        foreach ($this->table->selectRows() as $row) {
            $result[] = $row;
        }
        $this->assertEquals($expected, $result, "Should Select 5 rows");
        
    }

}