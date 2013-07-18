<?php

namespace wiro\modules\users\controllers\admin;

use CAction;
use wiro\helpers\FormHelper;
use wiro\modules\users\models\User;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class IndexAction extends CAction
{
    /**
     * Manages all models.
     */
    public function run()
    {
	$model = new User('search');
	$model->unsetAttributes();
	
	if (FormHelper::hasData($model, 'get'))
	    $model->attributes = FormHelper::getData($model, 'get');
	
	$this->controller->render('index', array(
	    'model' => $model,
	));
    }
}
