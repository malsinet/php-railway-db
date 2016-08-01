<?php

/**
 * DeleteTest class file
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
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
 * DeleteTest class
 *
 * Tests checking that correct DELETE queries are returned
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-validations
 */
class DeleteTest extends TestCase
{

	public function testEmptyTableThrowsException()
	{
        $delete = new Queries\Delete(
            new Queries\Base(
                $table="", $pk="id", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $delete->query();
    }
    
	public function testEmptyPkThrowsException()
	{
        $delete = new Queries\Delete(
            new Queries\Base(
                $table="user", $pk="", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $delete->query();
    }
    
	public function testEmptyOriginThrowsException()
	{
        $delete = new Queries\Delete($origin=null);
        $this->expectException(Queries\QueryException::class);
        $delete->query();
    }
    
	public function testValidDelete()
	{
        $delete = new Queries\Delete(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            )
        );
        $this->assertEquals(
            "DELETE FROM user WHERE (id = :id)",
            $delete->query(),
            "Delete query should be valid"
        );
    }

}