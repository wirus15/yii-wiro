<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\adapters;
use HASH\HASH;
use \Exception;
class_exists('HASH\HASH', false) or require 'HASH/HASH.php';
/**
 * @package HASH.adapters
 * @since 1.0
 */
final class CI_Hash extends HASH
{
	/**
	 * @var array
	 */
	private $_config;

	/**
	 * Constructor.
	 */
	public function __construct(array $config = array())
	{
		$this->config->load('hash', true);
		$this->_config = array_merge($this->config->item('hash'), $config);
	}

	/**
	 * Getter.
	 *
	 * Example:
	 * <code>
	 * $config = array(
	 * 	'pass' => array(
	 * 		'strategy' => HASH::SHA1_MD5_SALT,
	 * 		'salt' => 'q3XBgoiRCXfuTertfplXv1ICT',
	 * 	),
	 * 	'email' => array(
	 * 		'strategy' => HASH::MD5_SALT,
	 * 		'salt' => 'GswJNrMQAA_Q',
	 * 	),
	 * );
	 * $codeigniter->load->library('hash', $config);
	 * $password_hash = $codeigniter->hash->pass->make($password);
	 * $email_hash = $codeigniter->hash->email->make($email);
	 * </code>
	 * @param string $name
	 * @return mixed
	 * @throws Exception
	 */
	public function __get($name)
	{
		$CI = & get_instance();
		if (isset($this->_config[$name])) {
			return $this->$name = self::getInstance($name, $this->_config[$name]);
		} elseif (property_exists($CI, $name)) {
			return $CI->$name;
		}
		throw new Exception('_property_undefined');
	}
}