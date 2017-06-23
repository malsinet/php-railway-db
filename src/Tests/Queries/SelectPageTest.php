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


namespace github\malsinet\Railway\Database\Tests\Queries;

use PHPUnit\Framework\TestCase;
use github\malsinet\Railway\Database\RowToQuery;
use github\malsinet\Railway\Database\Queries as Q;


/**
 * SelectPageTest class
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
class SelectPageTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $select = new Q\SelectPage($origin=null);
        $this->expectException(Q\QueryException::class);
        $select->query(array());
    }
    
	public function testValidSelectPage()
	{
        $paged = new Q\SelectPage(
            new Q\Select(
                new Q\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            )
        );
        $row = array("name" => "Bob Marley", "age" => 27);
        $this->assertEquals(
            "SELECT * FROM (SELECT * FROM user WHERE (name = :name) AND (age = :age)) as t LIMIT :limit OFFSET :offset",
            $paged->query($row), "SelectPage must return a valid paged query"
        );
    }

	public function testSelectPageAll()
	{
        $paged = new Q\SelectPage(
            new Q\SelectAll(
                new Q\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            )
        );
        $this->assertEquals(
            "SELECT * FROM (SELECT * FROM user) as t LIMIT :limit OFFSET :offset",
            $paged->query(), "SelectPage must return a valid paged query"
        );
    }
}