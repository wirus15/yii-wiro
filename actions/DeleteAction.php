<?php

namespace wiro\actions;

use CHttpException;
use Closure;

/**
 * Deletes a particular model.
 */
class DeleteAction extends Action
{
    /**
     *
     * @var Closure
     */
    public $beforeDelete;

    /**
     * @param integer $id the ID of the model to be deleted
     */
    public function run($id)
    {
        $this->model = $this->loadModel($id);
        
        if (isset($this->accessCheck) && !$this->runClosure($this->accessCheck)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        
        if (isset($this->beforeDelete)) {
            $this->runClosure($this->beforeDelete);
        }
        
        $this->model->delete();

        if (!isset($_GET['ajax'])) {
            $this->redirect($this->redirectUrl ? : function() {
                return isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index');
            });
        }
    }

}
