<?php

namespace wiro\base;

use CFormModel;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class FormModel extends CFormModel
{
    public function getFormName()
    {
	$class = get_class($this);
	if(strpos($class, '\\') !== false)
	    return str_replace ('\\', '_', $class);
	return $class;
    }
}
