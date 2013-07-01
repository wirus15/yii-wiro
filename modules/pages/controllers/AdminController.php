<?php

namespace wiro\modules\pages\controllers;

use wiro\base\Controller;

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
	if (isset($_POST[$model->formName]))
	    $model->attributes = $_POST[$model->formName];
	$this->render('index', array(
	    'model' => $model,
	));
    }
    
    public function actionCreate()
    {
	$model = $this->module->pageFactory->create();
	if(isset($_POST[$model->formName])) {
	    $model->attributes = $_POST[$model->formName];
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
	if(isset($_POST[$model->formName])) {
	    $model->attributes = $_POST[$model->formName];
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
