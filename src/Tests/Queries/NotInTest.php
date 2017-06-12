<?php

/**
 * NotInTest class file
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
 * NotInTest class
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
class NotInTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $exclusion = new Queries\NotIn(
            null,
            $field="status_id",
            $inValues=array(1,2,3,4)
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
	public function testEmptyFieldThrowsException()
	{
        $exclusion = new Queries\NotIn(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="",
            $inValues=array(1,2,3,4)
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
	public function testEmptyNotInValuesThrowsException()
	{
        $exclusion = new Queries\NotIn(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status_id",
            $inValues=null
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
	public function testNotArrayNotInValuesThrowsException()
	{
        $exclusion = new Queries\NotIn(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status_id",
            $inValues="(1,2,3,4)"
        );
        $this->expectException(Queries\QueryException::class);
        $exclusion->query();
    }
    
 	public function testWhereNotIn()
	{
        $exclusion = new Queries\NotIn(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status_id",
            $inValues=array(1,2,3,4)
        );
        $this->assertStringEndsWith(
            " WHERE (status_id NOT IN (1, 2, 3, 4))",
            $exclusion->query(),
            "NotIn query should add a valid NOT IN clause"
        );
    }

 	public function testAndNotIn()
	{
        $exclusion = new Queries\NotIn(
            new Queries\Find(
                new Queries\Base(
                    $table="user", $pk="id", new RowToQuery()
                )
            ),
            $field="status_id",
            $inValues=array(1,2,3,4)
        );
        $this->assertStringEndsWith(
            " AND (status_id NOT IN (1, 2, 3, 4))",
            $exclusion->query(),
            "NotIn query should add a valid NOT IN clause"
        );
    }

 	public function testWhereNotInString()
	{
        $exclusion = new Queries\NotIn(
            new Queries\Base(
                $table="user", $pk="id", new RowToQuery()
            ),
            $field="status",
            $inValues=array("ACTIVE","MISSING","BLOCKED"),
            $stringBind=true
        );
        $this->assertStringEndsWith(
            " WHERE (status NOT IN ('ACTIVE', 'MISSING', 'BLOCKED'))",
            $exclusion->query(),
            "NotIn query should add a valid NOT IN clause with string binds"
        );
    }

 	public function testAndNotInString()
	{
        $exclusion = new Queries\NotIn(
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
            " AND (status NOT IN ('ACTIVE', 'MISSING', 'BLOCKED'))",
            $exclusion->query(),
            "NotIn query should add a valid NOT IN clause with string binds"
        );
    }
}