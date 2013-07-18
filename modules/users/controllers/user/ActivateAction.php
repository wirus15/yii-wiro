<?php

namespace wiro\modules\users\controllers\user;

use CAction;
use CHttpException;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ActivateAction extends CAction
{
    /**
     * 
     * @param integer $id
     * @param string $code
     * @throws CHttpException
     */
    public function run($id, $code)
    {
	$model = $this->controller->module->findUser($id);
	if ($model->active === true) 
	    Yii::app()->user->setFlash('success', Yii::t('wiro', 'This account has already been activated.'));
	else if ($model->activationCode === $code) {
	    $model->active = true;
	    $model->save();
	    Yii::app()->user->setFlash('success', Yii::t('wiro', 'Your account has been activated. You can now log in.'));
	} else 
	    throw new CHttpException(400, 'Incorrect activation code.');
	
	$this->controller->redirect(Yii::app()->homeUrl);
    }
}

