<?php

/**
 * ExclusionTest class file
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
 * ExclusionTest class
 *
 * Tests checking that correct excluision clauses get added
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class ExclusionTest extends TestCase
{

	public function testEmptyFieldThrowsException()
	{
        $exclusion = new Queries\Exclusion(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="",
            $value="DELETED"
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
	public function testEmptyValueThrowsException()
	{
        $exclusion = new Queries\Exclusion(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status",
            $value=""
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
	public function testEmptyOriginThrowsException()
	{
        $exclusion = new Queries\Exclusion(
            null,
            $field="status",
            $value=""
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
 	public function testWhereExclusion()
	{
        $exclusion = new Queries\Exclusion(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status",
            $value="DELETED"
        );
        $this->assertEquals("WHERE (status <> 'DELETED')", $exclusion->query(), "Exclusion query should add a WHERE clause");
    }

 	public function testAndExclusion()
	{
        $exclusion = new Queries\Exclusion(
            new Queries\Find(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $field="status", $value="DELETED"
        );
        $this->assertStringEndsWith("AND (status <> 'DELETED')", $exclusion->query(), "Exclusion query should add an AND clause");
    }
    
}