<?php

/**
 * UpdateQueryTest class file
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
use github\malsinet\Railway\Database\RowToQuery;
use github\malsinet\Railway\Database\Queries;


/**
 * UpdateQueryTest class
 *
 * Tests checking that a correct ORDER BY clause is added
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class UpdateQueryTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $update = new Queries\UpdateQuery($origin=null);
        $this->expectException(Queries\QueryException::class);
        $update->query(array());
    }
    
	public function testEmptyTableThrowsException()
	{
        $update = new Queries\UpdateQuery(
            new Queries\BaseQuery(
                $table="", $pk="id", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $update->query(array());
    }
    
	public function testEmptyPkThrowsException()
	{
        $update = new Queries\UpdateQuery(
            new Queries\BaseQuery(
                $table="user", $pk="", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $update->query(array());
    }
    
	public function testEmptyRowThrowsException()
	{
        $update = new Queries\UpdateQuery(
            new Queries\BaseQuery(
                $table="user", $pk="id", $row=null
            ) 
        );
        $this->expectException(Queries\QueryException::class);
        $update->query(array());
    }
    
	public function testValidUpdateQuery()
	{
        $update = new Queries\UpdateQuery(
            new Queries\BaseQuery(
                $table="user", $pk="id", new RowToQuery()
            ) 
        );
        $row = array("name" => "Bob Marley", "age" => 27);
        $this->assertEquals("UPDATE user SET name = :name, age = :age WHERE (id = :id)", $update->query($row), "UpdateQuery must be valid");
    }


}