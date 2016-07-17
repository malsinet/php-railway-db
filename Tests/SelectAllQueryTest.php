<?php

/**
 * SelectAllQueryTest class file
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-validations
 */


namespace github\malsinet\Railway\Database\Tests;

use PHPUnit\Framework\TestCase;
use github\malsinet\Railway\Database\RowToQuery;
use github\malsinet\Railway\Database\Queries;


/**
 * SelectAllQueryTest class
 *
 * Tests checking that correct SELECT queries are returned
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-validations
 */
class SelectAllQueryTest extends TestCase
{

	public function testEmptyTableThrowsException()
	{
        $select = new Queries\SelectAllQuery(
            new Queries\Base(
                $table="", $pk="id", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $select->query();
    }
    
	public function testEmptyOriginThrowsException()
	{
        $select = new Queries\SelectAllQuery($origin=null);
        $this->expectException(Queries\QueryException::class);
        $select->query();
    }
    
	public function testValidSelectAllQuery()
	{
        $select = new Queries\SelectAllQuery(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            )
        );
        $this->assertEquals("SELECT * FROM user", $select->query(), "SelectAll query should be valid");
    }

}