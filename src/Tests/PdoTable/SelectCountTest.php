<?php

/**
 * SelectCountTest class file
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
 * SelectCountTest class
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
class SelectCountTest extends TestCase
{

    public function setUp()
    {
        $this->db = new \PDO('sqlite::memory:');
        $this->db->setAttribute(
            \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
        );
        $this->db->exec("CREATE TABLE users (name TEXT, age INTEGER)");
        for ($i = 0; $i < 50; $i++)
        {
            $this->db->exec("INSERT INTO users (name, age) VALUES ('Joe', {$i})");
        }
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
    
	public function testFieldsParamNotArrayThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->selectCount("this is a string");
    }
    
	public function testWrongPredicateThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->selectCount(array("city" => "madrid"));
    }
    
	public function testSelectCount()
	{
        $this->assertEquals(50, $this->table->selectCount(), "Count should be 50 rows");
    }

	public function testSelectCountWithPredicates()
	{
         $table = new DB\PdoTable(
            $this->db,
            new DB\TableQueries(
                $insert=null,
                new DB\Queries\Select(
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

        $this->assertEquals(
            1,
            $table->selectCount(array("age" => "17")),
            "Single match should return count=1"
        );
        $this->assertEquals(
            50,
            $table->selectCount(array("name" => "Joe")),
            "Multiple match should return count=50"
        );
        $this->assertEquals(
            0,
            $table->selectCount(array("name" => "Mike")),
            "Unmatched predicate should return 0 rows"
        );
    }
}