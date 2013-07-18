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
final class BlowfishRandomSalt extends SimpleBlowfish
{
	/**
	 * @return string
	 * @see http://www.yiiframework.com/wiki/425/use-crypt-for-password-storage/
	 */
	protected function _blowfish()
	{
		for ($i = 0; $i < 8; ++$i) {
			$rand[] = pack('S', mt_rand(0, 0xffff));
		}
		$rand[] = substr(microtime(), 2, 6);
		$rand = sha1(implode('', $rand), true);
		$salt = "$2a\${$this->_cost}\$";
		$salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
		$salt .= '$';
		return $salt;
	}

	/**
	 * @param string $password
	 * @return bool
	 */
	public function isHashed($password)
	{
		return (bool) preg_match('/^\$\da\$\d{2}\$[.\/a-z0-9]{53}$/i', $password);
	}
}