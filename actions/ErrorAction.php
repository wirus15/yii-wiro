<?php

namespace wiro\actions;

use CAction;
use Yii;

/**
 * Description of ErrorAction
 *
 * @author wirus
 */
class ErrorAction extends CAction
{
    public $view = 'error';
    
    public function run()
    {
	if(($error = Yii::app()->errorHandler->error)) {
	    if(Yii::app()->request->isAjaxRequest)
		echo $error['message'];
	    else
		$this->controller->render($this->view, $error);
	}
    }
}
