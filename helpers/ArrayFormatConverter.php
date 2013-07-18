<?php

namespace wiro\helpers;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ArrayFormatConverter
{
    public static function toMultidimensional($array)
    {
	$data = array();
	foreach($array as $fullKey => $value)
	{
	    $keyParts = explode('.', $fullKey);
	    $key = array_pop($keyParts);
	    $current = &$data;
	    foreach($keyParts as $part) {
		if(!isset($current[$part]))
		    $current[$part] = array();
		$current = &$current[$part];
	    }
	    $current[$key] = $value;
	}
	return $data;
    }
}
