<?php

namespace wiro\helpers;

/**
 * Description of AttributeHelper
 *
 * @author wirus
 */
class DefaultAttributes
{
    public static function set($model, $values = array())
    {
	foreach($values as $attribute => $value) {
	    if($model->$attribute === null) {
		$model->$attribute = $value;
	    }
	}
    }
}
