<?php

namespace wiro\modules\users;

use CHttpException;
use CWebModule;
use wiro\modules\users\components\ProfileFactory;
use wiro\modules\users\models\User;
use Yii;

class UserModule extends CWebModule
{
    const NO_ACTIVATION = 0;
    const USER_ACTIVATION = 1;
    const ADMIN_ACTIVATION = 2;
    
    public $allowRegistration = true;
    
    public $accountActivation = self::USER_ACTIVATION;
    
    public $defaultController = 'user';
    
    public $profileClass;
	    
    public $controllerMap = array(
	'login' => 'wiro\modules\users\controllers\LoginController',
	'user' => 'wiro\modules\users\controllers\UserController',
	'admin' => 'wiro\modules\users\controllers\AdminController',
    );
    
    /**
     *
     * @var ProfileFactory
     */
    private $profileFactory;
    
    public function init()
    {
	parent::init();
	$this->profileFactory = new ProfileFactory($this->profileClass);
    }
    
    public function findUser($id = null)
    {
	if($id === null)
	    $id = Yii::app()->user->id;
	
	$model = User::model()->findByPk($id);
	if ($model === null)
	    throw new CHttpException(404, 'The requested page does not exist.');
	return $model;
    }
    
    public function createProfile($user, $scenario = 'insert')
    {
	return $this->profileFactory->create($user, $scenario);
    }
}
