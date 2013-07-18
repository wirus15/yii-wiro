<?php

namespace wiro\modules\users\components;

/**
 * Description of UserRegistration
 *
 * @author wirus
 */
class UserRegistration extends CApplicationComponent
{
    public $flashMessage;
    
    public function registerUser($user, $profile)
    {
	if($user->validate() && $profile->validate()) {
	    $user->save();
	    $profile->userId = $user->userId;
	    $profile->save();
	    
	    $this->setFlashMessage();
	    $this->sendActivationEmail($user, $profile);
	    return true;
	}
	return false;
    }
    
    private function setFlashMessage()
    {
	$defaultMessages = array(
	    UserModule::NO_ACTIVATION => Yii::t('UserModule.messages', 'Your account has been registered. You can log in now.'),
	    UserModule::USER_ACTIVATION => Yii::t('UserModule.messages', 'Your account has been registered. An email with activation link has been sent to you.'),
	    UserModule::ADMIN_ACTIVATION => Yii::t('UserModule.messages', 'Your account has been registered. Please wait until the administrator activates it.'),
	);
	
	$flashMessage = $this->flashMessage ? $this->flashMessage
	    : $defaultMessages[Yii::app()->getModule('user')->accountActivation];
	Yii::app()->user->setFlash('success', $flashMessage);
    }
    
    private function sendActivationEmail($user, $profile)
    {
	
    }
}