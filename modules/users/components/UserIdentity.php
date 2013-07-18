<?php

namespace wiro\modules\users\components;

use CUserIdentity;
use wiro\modules\users\models\User;
use Yii;

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    const ERROR_USER_INACTIVE = 3;
    const ERROR_USER_SUSPENDED = 4;

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
	$model = User::model()->find(
	    'username=:username OR email=:username', 
	    array('username' => $this->username)
	);
	
	if ($model === null)
	    $this->errorCode = self::ERROR_USERNAME_INVALID;
	else if (!Yii::app()->hash->pass->compare($this->password, $model->password))
	    $this->errorCode = self::ERROR_PASSWORD_INVALID;
	else if ($model->active == false)
	    $this->errorCode = self::ERROR_USER_INACTIVE;
	else if ($model->suspended == true)
	    $this->errorCode = self::ERROR_USER_SUSPENDED;
	else
	    $this->errorCode = self::ERROR_NONE;
	return !$this->errorCode;
    }
}