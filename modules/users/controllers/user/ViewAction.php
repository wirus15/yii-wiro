<?php

namespace wiro\modules\users\controllers\user;

use CAction;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ViewAction extends CAction
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function run($id = null)
    {
	$model = $this->controller->module->findUser($id);
	$this->controller->render('view', array(
	    'model' => $model,
	));
    }
}
