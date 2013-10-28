<?php

namespace wiro\actions;

use Closure;
use wiro\helpers\FormHelper;
use Yii;

/**
 * Creates a new model.
 */
class CreateAction extends Action
{
    /**
     * @var string
     */
    public $view = 'create';

    /**
     * @var Closure
     */
    public $beforePostAssignment;

    /**
     *
     * @var Closure
     */
    public $beforeSave;
    
    /**
     *
     * @var Closure
     */
    public $afterSave;

    public function run()
    {
        $this->model = Yii::createComponent(
                $this->modelClass ? : $this->controller->modelClass);

        if (isset($this->beforePostAssignment)) {
            $this->runClosure($this->beforePostAssignment);
        }

        if (FormHelper::hasData($this->model)) {
            $this->model->attributes = FormHelper::getData($this->model);
            if (isset($this->beforeSave)) {
                $this->runClosure($this->beforeSave);
            }
            if ($this->model->save()) {
                if (isset($this->afterSave)) {
                    $this->runClosure($this->afterSave);
                }
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
