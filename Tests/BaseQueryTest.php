<?php

/**
 * BaseQuery Test file
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
use github\malsinet\Railway\Database\Queries;


/**
 * BaseQueryTest class
 *
 * Test should return true
 *
 * @category   Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-validations
 */
class BaseQueryTest extends TestCase
{

	public function testBaseQueryReturnsEmptyString()
	{
        $base = new Queries\BaseQuery($table="user", $pk="id", $row);

        $this->assertEquals("", $base->query(), "BaseQuery should always return an empty string");
    }

}