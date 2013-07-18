<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\abstracts;
use HASH\HASH;
use \Exception;
if (HASH::$included) {
	class_exists('HASH\abstracts\SimpleHash', false) or require 'SimpleHash.php';
}
/**
 * @package HASH.abstracts
 * @since 1.0
 * @throws Exception
 */
abstract class SimpleSalted extends SimpleHash
{
	/**
	 * @var string
	 */
	protected $_salt;

	/**
	 * @param array $config
	 * @throws Exception
	 */
	public function __construct(array $config)
	{
		if ( ! isset($config['salt']) or ! is_string($config['salt']) or empty($config['salt'])) {
			throw new Exception('_invalid_salt');
		}
		$this->_salt = $config['salt'];
	}
}