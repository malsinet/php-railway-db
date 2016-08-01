<?php

/**
 * LimitTest class file
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
 * LimitTest class
 *
 * Tests checking that a correct LIMIT clause is added
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class LimitTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $select = new Queries\Limit(
            $origin=null,
            $limit="20",
            $offset="5"
        );
        $this->expectException(Queries\QueryException::class);
        $select->query();
    }
    
	public function testEmptyLimitThrowsException()
	{
        $ordered = new Queries\Limit(
            new Queries\SelectAll(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $limit="", $offset="5"
        );
        $this->expectException(Queries\QueryException::class);
        $ordered->query();
    }
    
	public function testEmptyOffsetThrowsException()
	{
        $ordered = new Queries\Limit(
            new Queries\SelectAll(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $limit="20", $offset=""
        );
        $this->expectException(Queries\QueryException::class);
        $ordered->query();
    }
    
	public function testValidLimit()
	{
        $ordered = new Queries\Limit(
            new Queries\SelectAll(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $limit="20", $offset="5"
        );
        $this->assertStringEndsWith(
            "LIMIT 20 OFFSET 5",
            $ordered->query(),
            "Limit query should end with a valid LIMIT clause"
        );
    }

}