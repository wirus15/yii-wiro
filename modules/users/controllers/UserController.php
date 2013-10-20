<?php

namespace wiro\modules\users\controllers;

use wiro\base\Controller;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class UserController extends Controller
{
    public $defaultAction = 'view';
    
    /**
     * @return array action filters
     */
    public function filters()
    {
	return array(
	    'accessControl',
	    'postOnly + delete',
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
		'actions' => array('register', 'activate', 'reset-password'),
		'users' => array('*'),
	    ),
	    array('allow',
		'users' => array('@'),
	    ),
	    array('deny',
		'users' => array('*'),
	    ),
	);
    }

    public function actions()
    {
	return array(
	    'view' => 'wiro\modules\users\controllers\user\ViewAction',
	    'activate' => 'wiro\modules\users\controllers\user\ActivateAction',
	    'update' => 'wiro\modules\users\controllers\user\UpdateAction',
	    'password' => 'wiro\modules\users\controllers\user\PasswordAction',
	    'reset-password' => 'wiro\modules\users\controllers\user\ResetPasswordAction',
	    'register' => 'wiro\modules\users\controllers\user\RegisterAction',
	);
    }
}
