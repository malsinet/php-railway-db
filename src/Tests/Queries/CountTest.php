<?php

/**
 * CountTest class file
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
use github\malsinet\Railway\Database\Queries as Q;


/**
 * CountTest class
 *
 * Tests checking that a valid pagination subquery is generated
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class CountTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $select = new Q\Count($origin=null);
        $this->expectException(Q\QueryException::class);
        $select->query(array());
    }
    
	public function testValidCount()
	{
        $paged = new Q\Count(
            new Q\Select(
                new Q\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            )
        );
        $row = array("name" => "Bob Marley", "age" => 27);
        $this->assertEquals(
            "SELECT count(1) as rowcount FROM (SELECT * FROM user WHERE (name = :name) AND (age = :age)) as t",
            $paged->query($row), "Count must return a valid paged query"
        );
    }

	public function testCountAll()
	{
        $paged = new Q\Count(
            new Q\SelectAll(
                new Q\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            )
        );
        $this->assertEquals(
            "SELECT count(1) as rowcount FROM (SELECT * FROM user) as t",
            $paged->query(), "Count must return a valid paged query"
        );
    }
}