<?php

namespace wiro\modules\login\components;

use CUserIdentity;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
	$module = Yii::app()->controller->module;
	
	if ($this->username !== $module->username)
	    $this->errorCode = self::ERROR_USERNAME_INVALID;
	elseif ($this->password !== $module->password)
	    $this->errorCode = self::ERROR_PASSWORD_INVALID;
	else
	    $this->errorCode = self::ERROR_NONE;
	return !$this->errorCode;
    }
}