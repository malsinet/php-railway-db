<?php

/**
 * SelectPageTest class file
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
 * SelectPageTest class
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
class SelectPageTest extends TestCase
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
        foreach ($this->table->selectPage(1, 10, "this is a string") as $row) {
            
        };
    }
    
	public function testWrongPredicateThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        foreach ($this->table->selectPage(1, 10, array("city"=>"Madrid")) as $row) {
            
        };
    }
    
	public function testSelectPage()
	{
        // Five pages with 10 records each
        foreach (range(0, 4) as $i) {
            $page = $this->table->selectPage($i+1, 10);
            $rows = $page["rows"];
            $this->assertEquals(10, count($rows), "Selected page should have 10 items");
            $this->assertEquals(10*$i, $rows[0]['age'],  "First item should be correct");
            $this->assertEquals(10*$i + 9, $rows[9]['age'],  "Last item should be correct");
        }
        // Ten pages with 5 records each
        foreach (range(0, 9) as $i) {
            $page = $this->table->selectPage($i+1, 5);
            $rows = $page["rows"];
            $this->assertEquals(5, count($rows), "Selected page should have 5 items");
            $this->assertEquals(5*$i, $rows[0]['age'],  "First item should be correct");
            $this->assertEquals(5*$i + 4, $rows[4]['age'],  "Last item should be correct");
        }
    }

	public function testSelectPageWithPredicates()
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

        $page = $table->selectPage($pageNum=1, $rowsPerPage=2, array("name" => "Joe"));
        $this->assertCount(2, $page["rows"], "Page should have 2 records");

        $page = $table->selectPage($pageNum=2, $rowsPerPage=3, array("name" => "Joe"));
        $this->assertCount(3, $page["rows"], "Page should have 3 records");

        $page = $table->selectPage($pageNum=3, $rowsPerPage=4, array("name" => "Joe"));
        $this->assertCount(4, $page["rows"], "Page should have 4 records");

        $page = $table->selectPage($page=4, $rowsPerPage=5, array("name" => "Joe"));
        $this->assertCount(5, $page["rows"], "Page should have 5 records");

        $page = $table->selectPage($page=1, $rowsPerPage=5, array("name" => "AAA"));
        $this->assertCount(0, $page["rows"], "Non-existent predicate should yield empty page");
    }
}