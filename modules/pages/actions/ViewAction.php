<?php

namespace wiro\modules\pages\actions;

use CAction;
use wiro\helpers\DefaultAttributes;
use Yii;

class ViewAction extends CAction 
{
    public $defaultView = 'pages.views.front.view';
    public $pageTitleTemplate;
    
    public function run($id)
    {
	DefaultAttributes::set($this, array(
	    'pageTitleTemplate' => Yii::app()->name.' - {pageTitle}',
	));
	
	$model = Yii::app()->getModule('pages')->loadPage($id);
	if($model->pageTitle) {
	    $pageTitle = str_replace('{pageTitle}', $model->pageTitle, $this->pageTitleTemplate);
	    $this->controller->pageTitle = $pageTitle;
	}
	$view = $model->pageView ? $model->pageView : $this->defaultView;
	
	$this->controller->render($view, array(
	    'model' => $model,
	));
    }   
}