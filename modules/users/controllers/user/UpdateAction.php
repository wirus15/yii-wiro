<?php

namespace wiro\modules\users\controllers\user;

use CAction;
use wiro\helpers\FormHelper;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class UpdateAction extends CAction
{
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function run($id = null)
    {
	$model = $this->controller->module->findUser($id);
	if(Yii::app()->request->isPostRequest) {
	    if(FormHelper::hasData($model))
		$model->attributes = FormHelper::getData ($model);
	    if($model->hasProfile && FormHelper::hasData($model->profile))
		$model->profile->attributes = FormHelper::getData($model->profile);

	    $transaction = Yii::app()->db->beginTransaction();
	    if($model->save() && (!$model->hasProfile || $model->profile->save())) {
		$transaction->commit();
		$this->controller->redirect(array('view', 'id' => $model->userId));
	    } else {
		$transaction->rollback();
	    }
	}
	
	$this->controller->render('update', array(
	    'model' => $model,
	));
    }
}
