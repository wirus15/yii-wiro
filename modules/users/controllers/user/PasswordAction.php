<?php


namespace wiro\modules\users\controllers\user;

use CAction;
use wiro\helpers\FormHelper;
use wiro\modules\users\models\forms\PasswordForm;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class PasswordAction extends CAction
{
    public function run()
    {
	$user = $this->controller->module->findUser();
	$model = new PasswordForm($user);

	if (FormHelper::hasData($model)) {
	    $model->attributes = FormHelper::getData($model);
	    if ($model->validate()) {
		$user->password = Yii::app()->hash->pass->make($model->password);
		$user->save();
		Yii::app()->user->setFlash('success', 
		    Yii::t('wiro', 'Your password has been changed.'));
		$this->controller->redirect(array('view'));
	    }
	}

	$model->unsetAttributes(array('password', 'confirmPassword'));
	$this->controller->render('password', array(
	    'user' => $user,
	    'model' => $model,
	));
    }
}
