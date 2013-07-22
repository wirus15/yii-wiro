<?php

namespace wiro\modules\pages\controllers;

use wiro\base\Controller;
use wiro\helpers\FormHelper;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class AdminController extends Controller 
{
    public $layout = '//layouts/admin';
    
    public function filters()
    {
	return array(
	    'accessControl',
	    'postOnly + delete'
	);
    }
    
    public function accessRules()
    {
	return array(
	    array('allow',
		'users' => array('@'),
	    ),
	    array('deny',
		'users' => array('*'),
	    ),
	);
    }
    
    public function actionIndex()
    {
	$model = $this->module->pageFactory->create('search');
	$model->unsetAttributes(); 
	if (FormHelper::hasData($model, 'get'))
	    $model->attributes = FormHelper::getData($model, 'get');
	$this->render('index', array(
	    'model' => $model,
	));
    }
    
    public function actionCreate()
    {
	$model = $this->module->pageFactory->create();
	if (FormHelper::hasData($model)) {
	    $model->attributes = FormHelper::getData($model);
	    if($model->save())
	        $this->redirect (array('index'));
	}
	
	$this->render('update', array(
	    'model' => $model,
	));
    }
    
    public function actionUpdate($id)
    {
	$model = $this->module->loadPage($id);
	if (FormHelper::hasData($model)) {
	    $model->attributes = FormHelper::getData($model);
	    if($model->save())
	        $this->redirect (array('index'));
	}

	$this->render('update', array(
	    'model' => $model,
	));
    }
    
    public function actionDelete($id)
    {
	$model = $this->module->loadPage($id);
	$model->delete();
	$this->redirect(array('index'));
    }
}
