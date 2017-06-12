<?php

/**
 * Base Test file
 *
 * @category   Query Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-validations
 */


namespace github\malsinet\Railway\Database\Tests\Queries;

use PHPUnit\Framework\TestCase;
use github\malsinet\Railway\Database\Queries;


/**
 * BaseQueryTest class
 *
 * Test should return true
 *
 * @category   Query Tests
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-validations
 */
class BaseTest extends TestCase
{

	public function testBaseReturnsEmptyString()
	{
        $base = new Queries\Base($table="user", $pk="id", $row);

        $this->assertEquals("", $base->query(), "Base should always return an empty string");
    }

}