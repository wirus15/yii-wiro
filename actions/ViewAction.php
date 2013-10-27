<?php

namespace wiro\actions;

/**
 * Displays a particular model.
 */
class ViewAction extends Action
{
    /**
     *
     * @var string
     */
    public $view = 'view';
    
    /**
     *
     * @var Closure
     */
    public $beforeRender;

    /**
     * @param integer $id the ID of the model to be displayed
     */
    public function run($id)
    {
        $model = $this->loadModel($id);
        
        if($this->beforeRender) {
            $this->runClosure($this->beforeRender, $model);
        }
        
        $this->controller->render($this->view, array(
            'model' => $model,
        ));
    }

}
