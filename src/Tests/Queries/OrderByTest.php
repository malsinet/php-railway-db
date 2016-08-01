<?php

/**
 * OrderByTest class file
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
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
 * OrderByTest class
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
class OrderByTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $select = new Queries\OrderBy(
            $origin=null,
            $orderBy="date",
            $direction="DESC"
        );
        $this->expectException(Queries\QueryException::class);
        $select->query();
    }
    
	public function testEmptyFieldThrowsException()
	{
        $ordered = new Queries\OrderBy(
            new Queries\SelectAll(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $orderBy="", $direction="DESC"
        );
        $this->expectException(Queries\QueryException::class);
        $ordered->query();
    }
    
	public function testEmptyDirectionThrowsException()
	{
        $ordered = new Queries\OrderBy(
            new Queries\SelectAll(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $orderBy="date", $direction=""
        );
        $this->expectException(Queries\QueryException::class);
        $ordered->query();
    }
    
	public function testValidOrderBy()
	{
        $ordered = new Queries\OrderBy(
            new Queries\SelectAll(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $orderBy="date", $direction="DESC"
        );
        $this->assertStringEndsWith(
            "ORDER BY date DESC",
            $ordered->query(),
            "OrderBy query should end with a valid ORDER BY clause"
        );
    }

}