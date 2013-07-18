<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\tests;
use \PHPUnit_Framework_TestCase;
use \ReflectionClass;
set_include_path('../../' . PATH_SEPARATOR . get_include_path());
class_exists('HASH\HASH', false) or require 'HASH/HASH.php';
/**
 * @package HASH.tests
 * @since 1.0
 */
abstract class HashUnitTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @return array
	 */
	public function provider()
	{
		$reflection = new ReflectionClass('HASH\HASH');
		$strategies = $reflection->getProperty('_strategiesMap');
		$strategies->setAccessible(true);
		$map = $strategies->getValue();
		$ids = array_keys($map);
		return array_map(function($id, $class) { return array($id, $class); }, $ids, $map);
	}
}