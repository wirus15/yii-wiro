<?php

namespace wiro\modules\users\components;

use AuthWebUser;
use wiro\helpers\DateHelper;
use wiro\modules\users\models\User;
use Yii;

Yii::import('wiro.modules.auth.components.AuthWebUser');

class WebUser extends AuthWebUser
{
    public $admins = array();
    /**
     *
     * @var array
     */
    public $loginUrl = array('/user/login/login');
    /**
     *
     * @var boolean
     */
    public $allowAutoLogin = true;
    /**
     * @var User
     */
    private $user;

    public function init()
    {
	parent::init();
	if ($this->isGuest === false) 
	    $this->loadUser();
    }

    /**
     * 
     * @return User
     */
    public function getUser()
    {
	return $this->user;
    }
    
    /**
     * 
     * @param boolean $fromCookie
     */
    protected function afterLogin($fromCookie)
    {
	$this->loadUser();
	$this->user->lastLogin = DateHelper::now();
	$this->user->save();
    }
   
    /**
     * 
     * @return User
     */
    private function loadUser()
    {
	if (is_numeric($this->id))
	    $this->user = User::model()->findByPk($this->id);
	elseif (is_string($this->id))
	    $this->user = User::model()->find(
		'username=:username OR email=:username', array('username' => $this->id));

	if ($this->user) {
	    $this->name = $this->user->username;
	    $this->id = $this->user->userId;
	}

	return $this->user;
    }
}
