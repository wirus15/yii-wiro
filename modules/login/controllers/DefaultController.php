<?php

namespace wiro\modules\login\controllers;

use wiro\base\Controller;
use wiro\modules\login\models\LoginForm;
use Yii;

/**
 * Description of LoginController
 *
 * @author wirus
 */
class DefaultController extends Controller
{
    public $defaultAction = 'login';
    
    /**
     * Displays the login page
     */
    public function actionLogin()
    {
	$model = new LoginForm();
	if(isset($_POST[$model->formName])) {
	    $model->attributes = $_POST[$model->formName];
	    if($model->validate() && $model->login())
		$this->redirect(Yii::app()->user->returnUrl);
	}
	$this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
	Yii::app()->user->logout();
	$this->redirect(Yii::app()->homeUrl);
    }
}

