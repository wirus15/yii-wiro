<?php

namespace wiro\modules\users\controllers;

use CActiveForm;
use wiro\base\Controller;
use wiro\helpers\FormHelper;
use wiro\modules\users\models\forms\LoginForm;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class LoginController extends Controller
{
    /**
     *
     * @var string
     */
    public $defaultAction = 'login';

    public function actionLogin()
    {
	$model = new LoginForm();
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}

	if (FormHelper::hasData($model)) {
	    $model->attributes = FormHelper::getData($model);
	    if ($model->validate() && $model->login()) 
		$this->redirect(Yii::app()->user->returnUrl);
	}
	$this->render('login', array('model' => $model));
    }

    public function actionLogout()
    {
	Yii::app()->user->logout();
	$this->redirect(Yii::app()->homeUrl);
    }
}