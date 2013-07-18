<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\adapters;
use HASH\HASH;
use \CApplicationComponent;
use \Exception;
use \Yii;
/**
 * @package HASH.adapters
 * @since 1.2
 */
class Yii_Hash extends CApplicationComponent
{
	protected $_strategies;

	public function init()
	{
		HASH::$included = false;
	}

	/**
	 * @return array
	 */
	public function getStrategies()
	{
		return $this->_strategies;
	}

	/**
	 * @param array $strategies
	 * @return array
	 */
	public function setStrategies(array $strategies)
	{
		foreach ($strategies as $key => $strategy) {
			$this->_strategies[$key] = $strategy;
		}
		return $strategies;
	}

	/**
	 * Getter.
	 *
	 * Example:
	 * <code>
	 * // config
	 * 'components' => array(
	 * 	'hash' => array(
	 * 		'class' => 'HASH\adapters\Yii_Hash',
	 * 		'strategies' => array(
	 * 			'pass' => array(
	 * 				'strategy' => HASH\HASH::SHA1_MD5_SALT,
	 * 				'salt' => 'q3XBgoiRCXfuTertfplXv1ICT',
	 * 			),
	 * 		),
	 * 	),
	 * ),
	 *
	 * // usage
	 * $password_hash = Yii::app()->hash->pass->make($password);
	 * </code>
	 * @param string $name
	 * @return mixed
	 * @throws Exception
	 */
	public function __get($name)
	{
		if (isset($this->_strategies[$name])) {
			$strategy = & $this->_strategies[$name];
			if (is_array($strategy)) {
				$strategy = HASH::getInstance($name, $this->_strategies[$name]);
			}
			return $strategy;
		}
		return parent::__get($name);
	}
}