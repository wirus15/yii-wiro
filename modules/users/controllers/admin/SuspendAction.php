<?php

namespace wiro\modules\users\controllers\admin;

use CAction;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class SuspendAction extends CAction
{
    /**
     * 
     * @param integer $id
     */
    public function run($id)
    {
	$model = $this->controller->module->findUser($id);
	$model->suspended = true;
	$model->save(false);
	$this->controller->redirect(array('view', 'id' => $model->userId));
    }
}
