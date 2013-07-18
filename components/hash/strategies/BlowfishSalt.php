<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\strategies;
use HASH\HASH;
use HASH\abstracts\SimpleBlowfish;
use \Exception;
if (HASH::$included) {
	class_exists('HASH\abstracts\SimpleBlowfish', false) or require 'HASH/abstracts/SimpleBlowfish.php';
}
/**
 * @package HASH.strategies
 * @since 1.1
 * @throws Exception
 */
final class BlowfishSalt extends SimpleBlowfish
{
	/**
	 * @param array $config
	 * @throws Exception
	 */
	public function __construct(array $config)
	{
		if ( ! isset($config['salt']) or ! preg_match('/^[.\/0-9A-Z-a-z]{22}$/', $config['salt'])) {
			throw new Exception('_invalid_salt');
		}
		parent::__construct($config);
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