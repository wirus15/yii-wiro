<?php

namespace wiro\modules\login\components;

use CWebUser;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class WebUser extends CWebUser
{
    public $allowAccess = array('admin', 'developer');
    
    public function checkAccess($operation, $params = array(), $allowCaching = true)
    {
	if(!$this->isGuest && in_array($operation, $this->allowAccess))
	    return true;
	return parent::checkAccess($operation, $params, $allowCaching);
    }
}
