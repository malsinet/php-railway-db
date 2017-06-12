<?php

/**
 * ExceptionTest class file
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
 * ExceptionTest class
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
class ExceptionTest extends TestCase
{

    public function setUp()
    {
        $this->db = new \PDO('sqlite::memory:');
        $this->db->setAttribute(
            \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
        );
        $this->db->exec("CREATE TABLE company (id INTEGER PRIMARY KEY, name TEXT, age INTEGER)");
        $this->table = new DB\PdoTable(
            $this->db,
            new DB\TableQueries(
                new DB\Queries\Insert(
                    new DB\Queries\Base(
                        $table="users", $pk="id", new DB\RowToQuery()
                    )
                ),
                new DB\Queries\Select(
                    new DB\Queries\Base(
                        $table="users", $pk="id", new DB\RowToQuery()
                    )
                ),
                new DB\Queries\Find(
                    new DB\Queries\Base(
                        $table="users", $pk="id", new DB\RowToQuery()
                    )
                ),
                new DB\Queries\Update(
                    new DB\Queries\Base(
                        $table="users", $pk="id", new DB\RowToQuery()
                    )
                ),
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
    
	public function testInsertThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->insertRow($fields=array("name" => "Fred"));
    }

	public function testSelectThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $fields=array("name" => "Fred");
        foreach($this->table->selectRows($fields) as $row) {
            $row["name"] = 2;
        }
    }

	public function testFindThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->findRowByFields($fields=array("name" => "Fred"));
    }

	public function testUpdateEmptyArrayThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->updateRow($fields=array());
    }
    
	public function testUpdateThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->updateRow($fields=array("name" => "Fred"));
    }

	public function testDeleteEmptyArrayThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->deleteRow($fields=array());
    }
    
	public function testDeleteThrowsException()
	{
        $this->expectException(DB\DatabaseException::class);
        $this->table->deleteRow($fields=array("name" => "Fred"));
    }

}