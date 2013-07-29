<?php

namespace wiro\modules\users\controllers\admin;

use CAction;
use wiro\components\mail\YiiMailMessage;
use wiro\helpers\FormHelper;
use wiro\helpers\StringHelper;
use wiro\modules\users\models\User;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class CreateAction extends CAction
{
    public function run()
    {
        $user = new User();
	$profile = $this->controller->module->createProfile($user);
	
	if(Yii::app()->request->isPostRequest) {
	    if(FormHelper::hasData($user))
		$user->attributes = FormHelper::getData($user);
	    if($profile && FormHelper::hasData($profile))
		$profile->attributes = FormHelper::getData($profile);
            
            $password = StringHelper::getRandom(8);
            $user->password = Yii::app()->hash->pass->make($password);
            $user->active = true;
            
	    $transaction = Yii::app()->db->beginTransaction();
	    if($this->saveUserAndProfile($user, $profile)) {
		$transaction->commit();
		$this->sendUserNotification($user, $password);
		$this->controller->redirect(array('view', 'id'=>$user->userId));
	    } else
		$transaction->rollback();
	}
	    
	$this->controller->render('create', array(
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
    
    private function sendUserNotification($user, $password)
    {
        $body = $this->controller->render('/email/create', array(
            'user' => $user,
            'password' => $password,
            'link' => $this->createLoginUrl(),
	));
	    
	$message = new YiiMailMessage;
	$message->setBody($body, 'text/html');
	$message->setSubject($this->controller->emailSubject);
	$message->setFrom(Yii::app()->params->adminEmail);
	$message->setTo($user->email);
	Yii::app()->mail->send($message);
    }
    
    private function createLoginUrl()
    {
        $baseUrl = Yii::app()->baseUrl;
        return str_replace(
                "$baseUrl/admin/", "$baseUrl/",
                Yii::app()->createAbsoluteUrl('/user/login'));
    }
}
