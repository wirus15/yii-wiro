<?php

namespace wiro\helpers;

use CException;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class FormHelper
{
    const GET = 'get';
    const POST = 'post';
    const ANY = 'any';
    
    public static function hasData($model, $method = self::POST)
    {
	switch($method) {
	    case self::GET:
		return isset($_GET[self::formName($model)]);
	    case self::POST:
		return isset($_POST[self::formName($model)]);
	    case self::ANY:
		return self::hasData($model, 'get') || self::hasData($model, 'post');
	    default:
		throw new CException('Unknown submit method: '.$method);
	}
    }
    
    public static function getData($model, $method = self::POST)
    {
	$req = Yii::app()->request;
	$formName = self::formName($model);
	switch($method) {
	    case self::GET:
		return $req->getQuery($formName);
	    case self::POST:
		return $req->getPost($formName);
	    case self::ANY:
		return $req->getParam($formName);
	    default:
		throw new CException('Unknown submit method: '.$method);
	}
    }
    
    public static function formName($model)
    {
	$class = get_class($model);
	if(strpos($class, '\\') !== false)
	    return str_replace ('\\', '_', $class);
	return $class;
    }
}
