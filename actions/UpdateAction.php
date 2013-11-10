<?php

namespace wiro\actions;

use CHttpException;
use Closure;
use wiro\helpers\FormHelper;

/**
 * Updates a particular model.
 * If update is successful, the browser will be redirected to the 'view' page.
 */
class UpdateAction extends Action
{
    /**
     *
     * @var string
     */
    public $view = 'update';

    /**
     * @var Closure
     */
    public $beforePostAssignment;

    /**
     * @param integer $id the ID of the model to be updated
     */
    public function run($id)
    {
        $this->model = $this->loadModel($id);

        if (isset($this->accessCheck) && !$this->runClosure($this->accessCheck)) {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
        
        if (isset($this->beforePostAssignment)) {
            $this->runClosure($this->beforePostAssignment);
        }

        if (FormHelper::hasData($this->model)) {
            $this->model->attributes = FormHelper::getData($this->model);
            if (isset($this->beforeSave)) {
                $this->runClosure($this->beforeSave);
            }
            if ($this->model->save()) {
                $this->redirect($this->redirectUrl ? : function($model) {
                        return array('view', 'id' => $model->primaryKey);
                    });
            }
        }

        $this->controller->render($this->view, array(
            'model' => $this->model,
        ));
    }

}
