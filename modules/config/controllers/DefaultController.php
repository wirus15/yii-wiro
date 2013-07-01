<?php

namespace wiro\modules\config\controllers;

use wiro\base\Controller;
use wiro\components\config\DbConfigValue;
use Yii;
use TbEditableSaver;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
	return array(
	    'accessControl', 
	);
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
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
    
    /**
     * Manages all models.
     */
    public function actionIndex()
    {
	$model = new DbConfigValue('search');
	$model->unsetAttributes(); 
	if (isset($_GET[$model->formName]))
	    $model->attributes = $_GET[$model->formName];

	$this->render('index', array(
	    'model' => $model,
	    'newModel' => new DbConfigValue(),
	));
    }
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCreate()
    {
	$model = new DbConfigValue();
	if (isset($_POST[$model->formName])) {
	    $model->attributes = $_POST[$model->formName];
	    $model->save();
	}
	$this->redirect(array('index'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id = null)
    {
	Yii::import('bootstrap.widgets.TbEditableSaver');
	$saver = new TbEditableSaver('wiro\components\config\DbConfigValue');
	$saver->update();
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
	$this->loadModel('wiro\components\config\DbConfigValue', $id)->delete();
	if (!isset($_GET['ajax']))
	    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }
}
