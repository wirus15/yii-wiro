<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\abstracts;
use HASH\HASH;
use \Exception;
if (HASH::$included) {
	class_exists('HASH\abstracts\SimpleSalted', false) or require 'SimpleSalted.php';
}
/**
 * @package HASH.abstracts
 * @since 1.1
 * @throws Exception
 */
abstract class SimpleBlowfish extends SimpleSalted
{
	/**
	 * @var int
	 */
	protected $_cost;

	/**
	 * @param array $config
	 * @throws Exception
	 */
	public function __construct(array $config)
	{
		if ( ! defined('CRYPT_BLOWFISH') or ! CRYPT_BLOWFISH) {
			throw new Exception('_blowfish_not_supported');
		}
		if ( ! isset($config['cost']) or ! is_int($config['cost']) or ($config['cost'] < 4 or $config['cost'] > 31)) {
			throw new Exception('_invalid_cost');
		}
		if (isset($config['salt'])) {
			if ( ! preg_match('/^[.\/0-9A-Z-a-z]{1,22}$/', $config['salt'])) {
				throw new Exception('_invalid_salt');
			}
			$this->_salt = str_pad($config['salt'], 22, '0');
		} else {
			$this->_salt = str_pad('', 22, '0');
		}
		$this->_cost = str_pad($config['cost'], 2, '0', STR_PAD_LEFT);
	}

	/**
	 * @param string $string
	 * @return string
	 */
	public function make($string)
	{
		return crypt($string, $this->_blowfish());
	}

	/**
	 * @param string $actual
	 * @param string $expected
	 * @return bool
	 */
	public function compare($actual, $expected)
	{
		return (crypt($actual, $expected) === $expected);
	}

	/**
	 * @return string
	 */
	protected function _blowfish()
	{
		return "$2a\${$this->_cost}\${$this->_salt}$";
	}
}