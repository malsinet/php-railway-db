<?php

/**
 * ExclusionQueryTest class file
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
 * ExclusionQueryTest class
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
class ExclusionQueryTest extends TestCase
{

	public function testEmptyFieldThrowsException()
	{
        $exclusion = new Queries\ExclusionQuery(
            new Queries\BaseQuery(
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
        $exclusion = new Queries\ExclusionQuery(
            new Queries\BaseQuery(
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
        $exclusion = new Queries\ExclusionQuery(
            null,
            $field="status",
            $value=""
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
 	public function testWhereExclusionQuery()
	{
        $exclusion = new Queries\ExclusionQuery(
            new Queries\BaseQuery(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status",
            $value="DELETED"
        );
        $this->assertEquals("WHERE (status <> 'DELETED')", $exclusion->query(), "Exclusion query should add a WHERE clause");
    }

 	public function testAndExclusionQuery()
	{
        $exclusion = new Queries\ExclusionQuery(
            new Queries\FindQuery(
                new Queries\BaseQuery(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $field="status", $value="DELETED"
        );
        $this->assertStringEndsWith("AND (status <> 'DELETED')", $exclusion->query(), "Exclusion query should add an AND clause");
    }
    
}