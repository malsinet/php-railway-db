<?php

/**
 * RowToQueryTest class file
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
use github\malsinet\Railway\Database\DatabaseException;


/**
 * RowToQueryTest class
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
class RowToQueryTest extends TestCase
{

	public function testToFieldsNotArrayThrowsException()
	{
        $row = new RowToQuery();
        $this->expectException(DatabaseException::class);
        $row->toFields("this is a string");
    }
    
	public function testValidRowToFields()
	{
        $row = new RowToQuery();
        $val = array("id" => 32, "name" => "Angus Young", "age" => 66);
        $this->assertEquals("id,name,age", $row->toFields($val), "Row->toFields should return valid fields");
    }

	public function testToValuesNotArrayThrowsException()
	{
        $row = new RowToQuery();
        $this->expectException(DatabaseException::class);
        $row->toValues("this is a string");
    }
    
	public function testValidRowToValues()
	{
        $row = new RowToQuery();
        $val = array("id" => 32, "name" => "Angus Young", "age" => 66);
        $this->assertEquals(":id,:name,:age", $row->toValues($val), "Row->toValues should return valid values");
    }

	public function testToPredicatesNotArrayThrowsException()
	{
        $row = new RowToQuery();
        $this->expectException(DatabaseException::class);
        $row->toPredicates("this is a string");
    }
    
	public function testValidRowToPredicates()
	{
        $row = new RowToQuery();
        $val = array("id" => 32, "name" => "Angus Young", "age" => 66);
        $this->assertEquals("(id = :id) AND (name = :name) AND (age = :age)", $row->toPredicates($val), "Row->toPredicates should return valid predicates");
    }

	public function testToBindsNotArrayThrowsException()
	{
        $row = new RowToQuery();
        $this->expectException(DatabaseException::class);
        $row->toBinds("this is a string");
    }
    
	public function testValidRowToBinds()
	{
        $row = new RowToQuery();
        $val = array("id" => 32, "name" => "Angus Young", "age" => 66);
        $this->assertEquals(array(":id" => 32, ":name" => "Angus Young", ":age" => 66), $row->toBinds($val), "Row->toBinds should return valid binds");
    }

	public function testToUpdateNotArrayThrowsException()
	{
        $row = new RowToQuery();
        $this->expectException(DatabaseException::class);
        $row->toUpdate("this is a string", "");
    }
    
	public function testValidRowToUpdate()
	{
        $row = new RowToQuery();
        $val = array("id" => 32, "name" => "Angus Young", "age" => 66);
        $this->assertEquals("name = :name, age = :age", $row->toUpdate($val, "id"), "Row->toBinds should return valid binds");
    }

}