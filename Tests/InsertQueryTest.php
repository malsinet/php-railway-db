<?php

/**
 * InsertQueryTest class file
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
 * InsertQueryTest class
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
class InsertQueryTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $insert = new Queries\InsertQuery($origin=null);
        $this->expectException(Queries\QueryException::class);
        $insert->query(array());
    }
    
	public function testEmptyTableThrowsException()
	{
        $insert = new Queries\InsertQuery(
            new Queries\BaseQuery(
                $table="", $pk="id", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $insert->query(array());
    }
    
	public function testEmptyRowThrowsException()
	{
        $insert = new Queries\InsertQuery(
            new Queries\BaseQuery(
                $table="user", $pk="id", $row=null
            ) 
        );
        $this->expectException(Queries\QueryException::class);
        $insert->query(array());
    }
    
	public function testValidInsertQuery()
	{
        $insert = new Queries\InsertQuery(
            new Queries\BaseQuery(
                $table="user", $pk="id", new RowToQuery()
            ) 
        );
        $row = array("id" => 23, "name" => "Bob Marley");
        $this->assertEquals("INSERT INTO user (id,name) VALUES (:id,:name)", $insert->query($row), "InsertQuery must be valid");
    }


}