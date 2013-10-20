<?php

namespace wiro\modules\users;

use CHttpException;
use CWebModule;
use wiro\modules\users\components\ProfileFactory;
use wiro\modules\users\models\User;
use wiro\modules\users\models\UserProfile;
use Yii;

class UserModule extends CWebModule
{
    const NO_ACTIVATION = 'none';
    const USER_ACTIVATION = 'user';
    const ADMIN_ACTIVATION = 'admin';
    
    /**
     * Is user registration enabled. However if this is false, 
     * admin is still able to add new users.
     * @var boolean
     */
    public $allowRegistration = true;
    /**
     * How accounts are activated after the registration. Can be one of the values:
     * UserModule::NO_ACTIVATION - accounts are already active after registration
     * UserModule::USER_ACTIVATION - accounts are activated by link send by email
     * UserModule::ADMIN_ACTIVATION - accounts are activated by site admin
     * @var string
     */
    public $accountActivation = self::USER_ACTIVATION;
    /**
     * Default module controller
     * @var string
     */
    public $defaultController = 'user';
    /**
     * Name of the user's profile class
     * @var string
     */
    public $profileClass;
	    
    public $controllerNamespace = 'wiro\modules\users\controllers';
    
    /**
     * A simple factory that creates user profile instances
     * @var ProfileFactory
     */
    private $profileFactory;
    
    public function init()
    {
	parent::init();
	$this->profileFactory = new ProfileFactory($this->profileClass);
    }
    
    /**
     * Finds a user with a given ID.
     * @param integer $id
     * @return User
     * @throws CHttpException
     */
    public function findUser($id = null)
    {
	if($id === null)
	    $id = Yii::app()->user->id;
	
	$model = User::model()->findByPk($id);
	if ($model === null)
	    throw new CHttpException(404, 'The requested page does not exist.');
	return $model;
    }
    
    /**
     * Creates a profile object for the given user.
     * @param User $user
     * @param string $scenario
     * @return UserProfile
     */
    public function createProfile($user, $scenario = 'insert')
    {
	return $this->profileFactory->create($user, $scenario);
    }
}
