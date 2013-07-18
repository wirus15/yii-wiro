<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\strategies;
use HASH\HASH;
use HASH\abstracts\SimpleSalted;
if (HASH::$included) {
	class_exists('HASH\abstracts\SimpleSalted');
}
/**
 * @package HASH.strategies
 * @since 1.0
 */
final class SaltSha1 extends SimpleSalted
{
	/**
	 * @param string $string
	 * @return string
	 */
	public function make($string)
	{
		return sha1("{$this->_salt}{$string}");
	}

	/**
	 * @param string $password
	 * @return bool
	 */
	public function isHashed($password)
	{
		return (bool) preg_match('/^[a-f0-9]{40}$/i', $password);
	}
}