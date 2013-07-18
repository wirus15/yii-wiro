<?php

namespace wiro\modules\users\models\forms;

use CFormModel;
use wiro\modules\users\components\UserIdentity;
use Yii;

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
	return array(
	    array('username, password', 'required'),
	    array('rememberMe', 'boolean'),
	    array('password', 'authenticate'),
	);
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
	return array(
	    'username' => Yii::t('wiro', 'Username'),
	    'password' => Yii::t('wiro', 'Password'),
	    'rememberMe' => Yii::t('wiro', 'Remember me'),
	);
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
	if (!$this->hasErrors()) {
	    $this->_identity = new UserIdentity($this->username, $this->password);
	    if (!$this->_identity->authenticate()) {
		if($this->_identity->errorCode == UserIdentity::ERROR_USER_INACTIVE)
		    $this->addError('username', Yii::t('wiro', 'Your account has not been activated yet.'));
		else if($this->_identity->errorCode == UserIdentity::ERROR_USER_SUSPENDED)
		    $this->addError('username', Yii::t('wiro', 'Your account has been suspended.'));
		else
		    $this->addError('password', Yii::t('wiro', 'Invalid username or password.'));
	    }
	}
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
	if ($this->_identity === null) {
	    $this->_identity = new UserIdentity($this->username, $this->password);
	    $this->_identity->authenticate();
	}
	if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
	    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
	    Yii::app()->user->login($this->_identity, $duration);
	    return true;
	}
	return false;
    }
}