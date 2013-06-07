<?php

namespace wiro\modules\pages\actions;

use CAction;
use Yii;

class ViewAction extends CAction 
{
    public $defaultView = 'pages.views.front.view';
    
    public function run($id)
    {
	$model = Yii::app()->getModule('pages')->loadPage($id);
	if($model->pageTitle)
	    $this->controller->pageTitle = $model->pageTitle;
	$view = $model->pageView ? $model->pageView : $this->defaultView;
	
	$this->controller->render($view, array(
	    'model' => $model,
	));
    }   
}