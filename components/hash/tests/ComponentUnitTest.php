<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\tests;
use HASH\HASH;
use \stdClass;
use \Exception;
class_exists('HashUnitTest', false) or require 'HashUnitTest.php';
/**
 * @package HASH.tests
 * @since 1.0
 */
final class ComponentUnitTest extends HashUnitTest
{
	/**
	 * Test getInstance exception.
	 */
	public function testIncorrectKey()
	{
		$keys = array(array(), new stdClass());
		$checksum = 0;
		foreach ($keys as $key) {
			try {
				HASH::getInstance($key);
			} catch (Exception $e) {
				$checksum++;
			}
		}
		try {
			HASH::getInstance(HASH::COMMON);
			HASH::getInstance(HASH::COMMON, array('strategy' => HASH::SHA1));
		} catch (Exception $e) {
			$checksum++;
		}
		try {
			HASH::getInstance(HASH::COMMON, array('strategy' => mt_rand(2000, 3000)));
		} catch (Exception $e) {
			$checksum++;
		}
		if ($checksum !== count($keys) + 2) {
			$this->fail("Exception for HASH::getInstance() wasn't triggered.");
		}
	}

	/**
	 * Test instances mapping.
	 *
	 * @dataProvider provider
	 * @param int $id
	 * @param string $class
	 */
	public function testStrategy($id, $class)
	{
		$file = $class;
		$class = "HASH\\strategies\\{$class}";
		class_exists($class, false) or require "HASH/strategies/{$file}.php";
		$salt = substr(md5(uniqid()), 0, 22);
		$cost = 11;
		$string = __FUNCTION__;
		$config = array(
			'strategy' => $id,
			'salt' => $salt,
			'cost' => $cost,
		);
		$strategy = new $class($config);
		$compare = HASH::getInstance($id, $config);
		if (preg_match('/BlowfishRandomSalt$/', $class)) {
			$hash = $compare->make($string);
			$this->assertTrue($strategy->compare($string, $hash));
		} else {
			$this->assertEquals($strategy->make($string), $compare->make($string));
		}
	}
}