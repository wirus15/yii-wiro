<?php

namespace wiro\modules\users\controllers\user;

use CAction;
use wiro\components\mail\YiiMailMessage;
use wiro\helpers\FormHelper;
use wiro\helpers\StringHelper;
use wiro\modules\users\models\User;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ResetPasswordAction extends CAction 
{
    /**
     *
     * @var User
     */
    private $user;
    /**
     *
     * @var string
     */
    private $newPassword;
    
    public function run()
    {
	$model = new User();
	if(FormHelper::hasData($model)) {
	    $model->attributes = FormHelper::getData($model);
	    if($this->findUser($model)) {
		$this->resetPassword();
		$this->sendPasswordToUser();
		Yii::app()->user->setFlash('success', 
		    Yii::t('wiro', 'A new password has been sent to your email address.'));
		$this->controller->redirect(Yii::app()->user->loginUrl);
	    }
	}
	
	$this->controller->render('resetPassword', array(
	    'model' => $model,
	));
    }
    
    /**
     * 
     * @param User $model
     * @return boolean
     */
    private function findUser($model)
    {
	$this->user = User::model()->find(
	    'username=:username OR email=:username', 
	    array('username' => $model->username)
	);
	
	if($this->user === null) 
	    $model->addError('username', Yii::t('wiro', 'Username or email not found.'));
	
	return $this->user!==null;
    }
    
    private function resetPassword()
    {
	$this->newPassword = StringHelper::getRandom(8);
	$this->user->password = $this->newPassword;
	$this->user->save();
    }
    
    private function sendPasswordToUser()
    {
	$body = $this->controller->render('/email/resetPassword', array(
	    'password' => $this->newPassword,
	    'link' => $this->controller->createAbsoluteUrl('/user/user/password'),
	), true);
	
	$message = new YiiMailMessage;
	$message->setSubject($this->controller->emailSubject);
	$message->setBody($body, 'text/html');
	$message->setFrom(Yii::app()->params->adminEmail);
	$message->setTo($this->user->email);
	Yii::app()->mail->send($message);
    }
}
