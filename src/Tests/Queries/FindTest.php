<?php

/**
 * FindTest class file
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-validations
 */


namespace github\malsinet\Railway\Database\Tests\Queries;

use PHPUnit\Framework\TestCase;
use github\malsinet\Railway\Database\RowToQuery;
use github\malsinet\Railway\Database\Queries;


/**
 * FindTest class
 *
 * Tests checking that correct SELECT queries are returned
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-validations
 */
class FindTest extends TestCase
{

	public function testEmptyTableThrowsException()
	{
        $find = new Queries\Find(
            new Queries\Base(
                $table="", $pk="id", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $find->query($row=array());
    }
    
	public function testEmptyRowThrowsException()
	{
        $find = new Queries\Find(
            new Queries\Base(
                $table="user", $pk="id", $row=null
            )
        );
        $this->expectException(Queries\QueryException::class);
        $find->query($row=array());
    }
    
	public function testEmptyOriginThrowsException()
	{
        $find = new Queries\Find($origin=null);
        $this->expectException(Queries\QueryException::class);
        $find->query($row=array());
    }
    
	public function testValidFind()
	{
        $find = new Queries\Find(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            )
        );
        $this->assertEquals("SELECT * FROM user WHERE (id = :id)", $find->query(array("id" => 23)), "Find query should be valid");
    }

}