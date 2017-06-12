<?php

/**
 * CompositeKeyTest class file
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
 * CompositeKeyTest class
 *
 * Tests checking that a composite key WHERE or AND clause is added
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
class CompositeKeyTest extends TestCase
{

	public function testEmptyOriginThrowsException()
	{
        $select = new Queries\CompositeKey($origin=null);
        $this->expectException(Queries\QueryException::class);
        $select->query(array());
    }
    
	public function testEmptyPkThrowsException()
	{
        $select = new Queries\CompositeKey(
            new Queries\Base(
                $table="user", $pk="", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $select->query(array());
    }
    
	public function testNotArrayPkThrowsException()
	{
        $select = new Queries\CompositeKey(
            new Queries\Base(
                $table="user", $pk="this is not an array", new RowToQuery()
            )
        );
        $this->expectException(Queries\QueryException::class);
        $select->query(array());
    }
    
	public function testAddWhereClause()
	{
        $update = new Queries\CompositeKey(
            new Queries\Update(
                new Queries\Base(
                    $table="company_user",
                    $pk=array("company_id", "user_id"),
                    new RowToQuery()
                )
            )
        );
        
        $row = array("name" => "Bob Marley", "age" => 27);
        $this->assertEquals(
            "UPDATE company_user SET name = :name, age = :age  WHERE (company_id = :company_id) AND (user_id = :user_id)",
            $update->query($row),
            "Update must end with composite WHERE clause"
        );
    }

	public function testAndClause()
	{
        $update = new Queries\Exclusion(
            new Queries\CompositeKey(
                new Queries\Update(
                    new Queries\Base(
                        $table="company_user",
                        $pk=array("company_id", "user_id"),
                        new RowToQuery()
                    )
                )
            ), $field="status", $value="DELETED"
        );        
        $row = array("name" => "Bob Marley", "age" => 27);
        $this->assertEquals(
            "UPDATE company_user SET name = :name, age = :age  WHERE (company_id = :company_id) AND (user_id = :user_id) AND (status <> 'DELETED')",
            $update->query($row),
            "Update must end with composite WHERE clause"
        );
    }


}
    