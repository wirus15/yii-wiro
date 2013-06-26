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
	$pageClass = $this->module->pageClass;
	$model = new $pageClass('search');
	$model->unsetAttributes(); 
	if ($data = $this->getQueryData())
	    $model->attributes = $data;
	$this->render('index', array(
	    'model' => $model,
	));
    }
    
    public function actionCreate()
    {
	$pageClass = $this->module->pageClass;
	$model = new $pageClass();
	if($data = $this->getPostData()) {
	    $model->attributes = $data;
	    if($model->save())
	        $this->redirect (array('index'));
	}
	
	$this->render('update', array(
	    'model' => $model,
	));
    }
    
    public function actionUpdate($id)
    {
	$pageClass = $this->module->pageClass;
	$model = $this->module->loadPage($id);
	if($data = $this->getPostData()) {
	    $model->attributes = $data;
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
    
    private function getPostData()
    {
	$class = str_replace('\\', '_', $this->module->pageClass);
	if(isset($_POST[$class]))
	    return $_POST[$class];
	else
	    return null;
    }
    
    private function getQueryData()
    {
	$class = str_replace('\\', '_', $this->module->pageClass);
	if(isset($_GET[$class]))
	    return $_GET[$class];
	else
	    return null;
    }
}
