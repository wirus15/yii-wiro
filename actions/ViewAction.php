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
     * @param integer $id the ID of the model to be displayed
     */
    public function run($id)
    {
        $this->controller->render($this->view, array(
            'model' => $this->loadModel($id),
        ));
    }

}
