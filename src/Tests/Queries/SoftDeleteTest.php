<?php

/**
 * SoftDeleteTest class file
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Tests\Queries;

use PHPUnit\Framework\TestCase;
use github\malsinet\Railway\Database\RowToQuery;
use github\malsinet\Railway\Database\Queries;


/**
 * SoftDeleteTest class
 *
 * Tests checking that a correct ORDER BY clause is added
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class SoftDeleteTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $delete = new Queries\SoftDelete(
            $origin=null, $field="status", $value="DELETED"
        );
        $this->expectException(Queries\QueryException::class);
        $delete->query();
    }
    
	public function testEmptyTableThrowsException()
	{
        $delete = new Queries\SoftDelete(
            new Queries\Base(
                $table="", $pk="id", new RowToQuery()
            ), $field="status", $value="DELETED"
        );
        $this->expectException(Queries\QueryException::class);
        $delete->query();
    }
    
	public function testEmptyPkThrowsException()
	{
        $delete = new Queries\SoftDelete(
            new Queries\Base(
                $table="user", $pk="", new RowToQuery()
            ), $field="status", $value="DELETED"
        );
        $this->expectException(Queries\QueryException::class);
        $delete->query();
    }
    
	public function testEmptyFieldThrowsException()
	{
        $delete = new Queries\SoftDelete(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ), $field="", $value="DELETED"
        );
        $this->expectException(Queries\QueryException::class);
        $delete->query();
    }
    
	public function testEmptyValueThrowsException()
	{
        $delete = new Queries\SoftDelete(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ), $field="status", $value=""
        );
        $this->expectException(Queries\QueryException::class);
        $delete->query();
    }
    
	public function testValidSoftDelete()
	{
        $delete = new Queries\SoftDelete(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ), $field="status", $value="DELETED"
        );
        $this->assertEquals("UPDATE user SET status = 'DELETED' WHERE (id = :id)", $delete->query(), "SoftDelete query should be a valid UPDATE query");
    }

}