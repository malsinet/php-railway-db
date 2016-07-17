<?php

/**
 * FilteredQueryTest class file
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
 * FilteredQueryTest class
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
class FilteredQueryTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $filtered = new Queries\FilteredQuery(
            new Queries\SelectAllQuery(
                $origin=null
            ), $field="status", $value="ACTIVE"
        );
        $this->expectException(Queries\QueryException::class);
        $filtered->query();
    }
    
	public function testEmptyFieldThrowsException()
	{
        $filtered = new Queries\FilteredQuery(
            new Queries\SelectAllQuery(
                new Queries\BaseQuery(
                    $table="user", $pk="id", new RowToQuery()
                )
            ), $field="", $value="ACTIVE"
        );
        $this->expectException(Queries\QueryException::class);
        $filtered->query();
    }
    
	public function testEmptyValueThrowsException()
	{
        $filtered = new Queries\FilteredQuery(
            new Queries\SelectAllQuery(
                new Queries\BaseQuery(
                    $table="user", $pk="id", new RowToQuery()
                ) 
            ), $field="status", $value=""
        );
        $this->expectException(Queries\QueryException::class);
        $filtered->query();
    }
    
	public function testValidWhereFilteredQuery()
	{
        $filtered = new Queries\FilteredQuery(
            new Queries\SelectAllQuery(
                new Queries\BaseQuery(
                    $table="user", $pk="id", new RowToQuery()
                ) 
            ), $field="status", $value="ACTIVE"
        );
        $this->assertStringEndsWith("WHERE (status = 'ACTIVE')", $filtered->query(), "Filtered query ends with WHERE clause");
    }

	public function testValidAndFilteredQuery()
	{
        $filtered = new Queries\FilteredQuery(
            new Queries\ExclusionQuery(
                new Queries\SelectAllQuery(
                    new Queries\BaseQuery(
                        $table="user", $pk="id", new RowToQuery()
                    )
                ), $exclude="role", $value="ADMIN"
            ), $field="status", $value="ACTIVE"
        );
        $this->assertStringEndsWith("WHERE (status = 'ACTIVE')", $filtered->query(), "Filtered query ends with AND clause");
    }

}