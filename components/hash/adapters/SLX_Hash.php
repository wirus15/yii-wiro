<?php
/**
 * @author Samigullin Kamil <feedback@kamilsk.com>
 * @link http://www.kamilsk.com/
 */
namespace HASH\adapters;
use HASH\HASH;
use Silex\Application;
use Silex\ServiceProviderInterface;
class_exists('HASH\HASH') or require 'HASH/HASH.php';
/**
 * @package HASH.adapters
 * @since 1.1
 */
class SLX_Hash implements ServiceProviderInterface
{
	/**
	 * @param Application $app
	 * @return void
	 */
	public function register(Application $app)
	{
		$app['hash.task'] = 0;
		$app['hash.config'] = array();
		$app['hash'] = $app->share(function ($app) {
			return HASH::getInstance($app['hash.task'], $app['hash.config']);
		});
	}

	/**
	 * @param Application $app
	 * @return void
	 */
	public function boot(Application $app)
	{}
}