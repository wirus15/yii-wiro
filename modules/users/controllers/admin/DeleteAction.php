<?php

namespace wiro\modules\users\controllers\admin;

use CAction;
use CHttpException;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DeleteAction extends CAction
{
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function run($id)
    {
	if (Yii::app()->request->isPostRequest) {
	    $model = $this->controller->module->findUser($id);
	    $model->delete();
	    $this->controller->redirect(array('index'));
	}
	else 
	    throw new CHttpException(400);
    }
}
