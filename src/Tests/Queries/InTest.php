<?php

/**
 * InTest class file
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
use github\malsinet\Railway\Database\Queries;


/**
 * InTest class
 *
 * Tests checking that correct excluision clauses get added
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class InTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $exclusion = new Queries\In(
            null,
            $field="status_id",
            $inValues=array(1,2,3,4)
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
	public function testEmptyFieldThrowsException()
	{
        $exclusion = new Queries\In(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="",
            $inValues=array(1,2,3,4)
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
	public function testEmptyInValuesThrowsException()
	{
        $exclusion = new Queries\In(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status_id",
            $inValues=null
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
	public function testNotArrayInValuesThrowsException()
	{
        $exclusion = new Queries\In(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status_id",
            $inValues="(1,2,3,4)"
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
 	public function testWhereIn()
	{
        $exclusion = new Queries\In(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status_id",
            $inValues=array(1,2,3,4)
        );
        $this->assertStringEndsWith(
            " WHERE (status_id IN (1, 2, 3, 4))",
            $exclusion->query(),
            "In query should add a valid IN clause"
        );
    }

 	public function testAndIn()
	{
        $exclusion = new Queries\In(
            new Queries\Find(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ),
            $field="status_id",
            $inValues=array(1,2,3,4)
        );
        $this->assertStringEndsWith(
            " AND (status_id IN (1, 2, 3, 4))",
            $exclusion->query(),
            "In query should add a valid IN clause"
        );
    }

 	public function testWhereInString()
	{
        $exclusion = new Queries\In(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status",
            $inValues=array("ACTIVE","MISSING","BLOCKED"),
            $stringBind=true
        );
        $this->assertStringEndsWith(
            " WHERE (status IN ('ACTIVE', 'MISSING', 'BLOCKED'))",
            $exclusion->query(),
            "In query should add a valid IN clause with string binds"
        );
    }

 	public function testAndInString()
	{
        $exclusion = new Queries\In(
            new Queries\Find(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ),
            $field="status",
            $inValues=array("ACTIVE","MISSING","BLOCKED"),
            $stringBind=true
        );
        $this->assertStringEndsWith(
            " AND (status IN ('ACTIVE', 'MISSING', 'BLOCKED'))",
            $exclusion->query(),
            "In query should add a valid IN clause with string binds"
        );
    }
}