<?php

/**
 * SelectAllTest class file
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
 * SelectAllTest class
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
class SelectAllTest extends TestCase
{

	public function testEmptyTableThrowsException()
	{
        $select = new Queries\SelectAll(
            new Queries\Base(
                $table="", $pk="id", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $select->query();
    }
    
	public function testEmptyOriginThrowsException()
	{
        $select = new Queries\SelectAll($origin=null);
        $this->expectException(Queries\QueryException::class);
        $select->query();
    }
    
	public function testValidSelectAll()
	{
        $select = new Queries\SelectAll(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            )
        );
        $this->assertEquals("SELECT * FROM user", $select->query(), "SelectAll query should be valid");
    }

}