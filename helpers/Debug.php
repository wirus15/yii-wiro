<?php

namespace wiro\helpers;

use CHtml;
use CVarDumper;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class Debug  
{
    public static function prnt($value, $die = true)
    {
	echo '<pre>'.CHtml::encode(print_r($value, 1)).'</pre>';
	if($die) die();
    }
    
    public static function dump($value, $die = true)
    {
        echo '<pre>';
        ob_start();
	CVarDumper::dump($value);
        echo CHtml::encode(ob_get_clean());
        echo '</pre>';
	if($die) die();
    }
    
    public static function hdump($value, $die = true)
    {
	CVarDumper::dump($value, 10, true);
    }
}
