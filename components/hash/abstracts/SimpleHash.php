<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\abstracts;
use HASH\HASH;
use HASH\interfaces\iHash;
use \Exception;
if (HASH::$included) {
	interface_exists('HASH\interfaces\iHash', false) or require 'HASH/interfaces/iHash.php';
}
/**
 * @package HASH.abstracts
 * @since 1.0
 */
abstract class SimpleHash implements iHash
{
	/**
	 * @param string $string
	 * @return string
	 * @throws Exception
	 */
	public function make($string)
	{
		throw new Exception('_make_not_implemented');
	}

	/**
	 * @param string $actual
	 * @param string $expected
	 * @return bool
	 */
	public function compare($actual, $expected)
	{
		return ($this->make($actual) === $expected);
	}
}