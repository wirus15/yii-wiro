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
    public $pageClass = 'wiro\modules\pages\models\Page';
    
    public $controllerMap = array(
	'admin' => 'wiro\modules\pages\controllers\AdminController',
    );
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @return ActiveRecord 
     */
    public function loadPage($id)
    {
	$primaryKey = ActiveRecord::model($this->pageClass)->tableSchema->primaryKey;
	$model = ActiveRecord::model($this->pageClass)->find(array(
	    'condition' => $primaryKey.'=:id OR pageAlias=:id',
	    'params' => array(':id' => $id),
	));
	if ($model === null)
	    throw new CHttpException(404, Yii::t('wiro', 'The requested page does not exist.'));
	return $model;
    }
}
