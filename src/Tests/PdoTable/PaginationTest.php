<?php

/**
 * PaginationTest class file
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
 * PaginationTest class
 *
 * Tests checking Pagination calculations
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class PaginationTest extends TestCase
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
    
	public function testPaginationExactRows()
	{
        $page = $this->table->pagination($page=4, $rowsPerPage=10, $totalRows=100);
        $this->assertEquals(3, $page["prev_page"], "Previous page should be 3");
        $this->assertEquals(5, $page["next_page"], "Next page should be 5");
        $this->assertEquals(1, $page["first_page"], "First page should be 1");
        $this->assertEquals(10, $page["last_page"], "Last page should be 10");
        $this->assertEquals(31, $page["first_row"], "First row should be 31");
        $this->assertEquals(40, $page["last_row"], "Last row should be 40");
        $this->assertEquals(10, $page["total_pages"], "Total pages should be 10");
    }

	public function testPaginationRowsRemaining()
	{
        $page = $this->table->pagination($page=10, $rowsPerPage=10, $totalRows=97);
        $this->assertEquals(9, $page["prev_page"], "Previous page should be 9");
        $this->assertEquals(10, $page["next_page"], "Next page should be 10");
        $this->assertEquals(1, $page["first_page"], "First page should be 1");
        $this->assertEquals(10, $page["last_page"], "Last page should be 10");
        $this->assertEquals(91, $page["first_row"], "First row should be 91");
        $this->assertEquals(97, $page["last_row"], "Last row should be 97");
        $this->assertEquals(10, $page["total_pages"], "Total pages should be 10");
    }
}