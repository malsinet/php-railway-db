<?php

/**
 * OrderedQueryTest class file
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
 * OrderedQueryTest class
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
class OrderedQueryTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $select = new Queries\OrderedQuery($origin=null, $orderBy="date", $direction="DESC");
        $this->expectException(Queries\QueryException::class);
        $select->query();
    }
    
	public function testEmptyFieldThrowsException()
	{
        $ordered = new Queries\OrderedQuery(
            new Queries\SelectAllQuery(
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
        $ordered = new Queries\OrderedQuery(
            new Queries\SelectAllQuery(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $orderBy="date", $direction=""
        );
        $this->expectException(Queries\QueryException::class);
        $ordered->query();
    }
    
	public function testValidOrderedQuery()
	{
        $ordered = new Queries\OrderedQuery(
            new Queries\SelectAllQuery(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $orderBy="date", $direction="DESC"
        );
        $this->assertStringEndsWith("ORDER BY date DESC", $ordered->query(), "Ordered query should end with a valid ORDER BY clause");
    }

}