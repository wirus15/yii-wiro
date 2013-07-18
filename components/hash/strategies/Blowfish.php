<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\strategies;
use HASH\HASH;
use HASH\abstracts\SimpleBlowfish;
if (HASH::$included) {
	class_exists('HASH\abstracts\SimpleBlowfish', false) or require 'HASH/abstracts/SimpleBlowfish.php';
}
/**
 * @package HASH.strategies
 * @since 1.1
 */
final class Blowfish extends SimpleBlowfish
{
	/**
	 * @param string $password
	 * @return bool
	 */
	public function isHashed($password)
	{
		return (bool) preg_match('/^\$\da\$\d{2}\$[.\/a-z0-9]{53}$/i', $password);
	}
}