<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\tests;
use HASH\HASH;
class_exists('HashUnitTest', false) or require 'HashUnitTest.php';
/**
 * @package HASH.tests
 * @since 1.0
 */
final class StrategiesUnitTest extends HashUnitTest
{
	/**
	 * @dataProvider provider
	 * @param int $id
	 * @param string $class
	 */
	public function testFileExists($id, $class)
	{
		$file = "../strategies/{$class}.php";
		$this->assertFileExists($file);
		require $file;
	}

	/**
	 * @dataProvider provider
	 * @depends testFileExists
	 * @param int $id
	 * @param string $class
	 */
	public function testClassExists($id, $class)
	{
		$class = "HASH\\strategies\\{$class}";
		$this->assertTrue(class_exists($class));
	}
}