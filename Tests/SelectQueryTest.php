<?php

/**
 * SelectQueryTest class file
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
 * SelectQueryTest class
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
class SelectQueryTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $select = new Queries\SelectQuery($origin=null);
        $this->expectException(Queries\QueryException::class);
        $select->query(array());
    }
    
	public function testEmptyTableThrowsException()
	{
        $select = new Queries\SelectQuery(
            new Queries\BaseQuery(
                $table="", $pk="id", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $select->query(array());
    }
    
	public function testEmptyRowThrowsException()
	{
        $select = new Queries\SelectQuery(
            new Queries\BaseQuery(
                $table="user", $pk="id", $row=null
            ) 
        );
        $this->expectException(Queries\QueryException::class);
        $select->query(array());
    }
    
	public function testValidSelectQuery()
	{
        $select = new Queries\SelectQuery(
            new Queries\BaseQuery(
                $table="user", $pk="id", new RowToQuery()
            ) 
        );
        $row = array("name" => "Bob Marley", "age" => 27);
        $this->assertEquals("SELECT * FROM user WHERE (name = :name) AND (age = :age)", $select->query($row), "SelectQuery must be valid");
    }


}