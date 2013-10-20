<?php

namespace wiro\actions;

use Closure;
use wiro\helpers\FormHelper;
use Yii;

/**
 * Manages all models.
 */
class IndexAction extends Action
{
    /**
     *
     * @var string
     */
    public $view = 'index';

    /**
     * @var Closure
     */
    public $beforeQueryAssignment;

    /**
     * 
     * @param integer $category
     */
    public function run()
    {
        $this->model = Yii::createComponent(
                $this->modelClass ? : $this->controller->modelClass);
        $this->model->scenario = 'search';
        $this->model->unsetAttributes();

        if (isset($this->beforeQueryAssignment)) {
            $this->runClosure($this->beforeQueryAssignment);
        }

        if (FormHelper::hasData($this->model, FormHelper::GET)) {
            $this->model->attributes = FormHelper::getData($this->model, FormHelper::GET);
        }

        $this->controller->render($this->view, array(
            'model' => $this->model,
        ));
    }

}
