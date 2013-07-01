<?php

namespace wiro\modules\pages;

use CHttpException;
use CWebModule;
use wiro\base\ActiveRecord;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class PagesModule extends CWebModule
{
    public $defaultController = 'admin';
    public $controllerNamespace = 'wiro\modules\pages\controllers';
    
    protected function preinit()
    {
	$this->setComponents(array(
	    'pageFactory' => array(
		'class' => 'wiro\modules\pages\components\PageFactory',
	    ),
	));
	parent::preinit();
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @return ActiveRecord 
     */
    public function loadPage($id)
    {
	$model = $this->pageFactory->find(array(
	    'condition' => 'pageId=:id OR pageAlias=:id',
	    'params' => array(':id' => $id),
	));
	if ($model === null)
	    throw new CHttpException(404, Yii::t('wiro', 'The requested page does not exist.'));
	return $model;
    }
}
