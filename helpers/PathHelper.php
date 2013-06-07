<?php

namespace wiro\helpers;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class PathHelper
{
    public static function build($parts) {
	if(!is_array($parts))
	    $parts = func_get_args();
	
	for($i=0, $n=count($parts)-1; $i<=$n; $i++) {
	    if($i === 0)
		$parts[0] = rtrim($parts[0], '/\\');
	    elseif($i === $n)
		$parts[$n] = ltrim($parts[$n], '/\\');
	    else
		$parts[$i] = trim($parts[$i], '/\\');
	}
	
	$parts = array_filter($parts);
	return implode(DIRECTORY_SEPARATOR, $parts);    
    }
}
