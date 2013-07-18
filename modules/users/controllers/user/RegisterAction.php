<?php

namespace wiro\modules\users\controllers\user;

use CAction;
use wiro\components\mail\YiiMailMessage;
use wiro\helpers\FormHelper;
use wiro\modules\users\models\User;
use wiro\modules\users\UserModule;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class RegisterAction extends CAction
{
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function run()
    {
	if(!$this->controller->module->allowRegistration)
	    throw new \CHttpException(403, 'User registration is disabled.');
	
	$user = new User();
	$profile = $this->controller->module->createProfile($user);
	
	if(Yii::app()->request->isPostRequest) {
	    if(FormHelper::hasData($user))
		$user->attributes = FormHelper::getData($user);
	    if($profile && FormHelper::hasData($profile))
		$profile->attributes = FormHelper::getData($profile);
	
	    $transaction = Yii::app()->db->beginTransaction();
	    if($this->saveUserAndProfile($user, $profile)) {
		$transaction->commit();
		$this->setFlashMessage();
		$this->sendActivationEmail($user, $profile);
		$this->controller->redirect(Yii::app()->homeUrl);
	    } else
		$transaction->rollback();
	}
	    
	$this->controller->render('register', array(
	    'user' => $user,
	    'profile' => $profile,
	));
    }
    
    private function saveUserAndProfile($user, $profile)
    {
	if($user->save() === false)
	    return false;
	if($profile !== null) {
	    $profile->userId = $user->userId;
	    return $profile->save();
	}
	return true;
    }
    
    private function setFlashMessage()
    {
	$messages = array(
	    UserModule::NO_ACTIVATION => Yii::t('wiro', 'Your account has been registered. You can log in now.'),
	    UserModule::USER_ACTIVATION => Yii::t('wiro', 'Your account has been registered. An email with activation link has been sent to you.'),
	    UserModule::ADMIN_ACTIVATION => Yii::t('wiro', 'Your account has been registered. Please wait until the administrator activates it.'),
	);
	
	$flashMessage = $messages[Yii::app()->getModule('user')->accountActivation];
	Yii::app()->user->setFlash('success', $flashMessage);
    }

    private function sendActivationEmail($user, $profile)
    {
	if ($this->controller->module->accountActivation === UserModule::USER_ACTIVATION) {
	    $body = $this->controller->render('/email/register', array(
		'user' => $user,
		'profile' => $profile,
		'link' => Yii::app()->createAbsoluteUrl('/user/user/activate', array('id'=>$user->userId, 'code'=>$user->activationCode)), 
	    ));
	    
	    $message = new YiiMailMessage;
	    $message->setBody($body, 'text/html');
	    $message->setSubject($this->controller->emailSubject);
	    $message->setFrom(Yii::app()->params->adminEmail);
	    $message->setTo($this->user->email);
	    Yii::app()->mail->send($message);
	}
    }
}
