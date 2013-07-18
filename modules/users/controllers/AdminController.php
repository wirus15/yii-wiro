<?php

namespace wiro\modules\users\controllers;

use wiro\base\Controller;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class AdminController extends Controller
{
    public $layout = '//layouts/admin';
    
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
		'roles' => array('admin'),
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
	    'update' => 'wiro\modules\users\controllers\user\UpdateAction',
	    'activate' => 'wiro\modules\users\controllers\admin\ActivateAction',
	    'index' => 'wiro\modules\users\controllers\admin\IndexAction',
	    'suspend' => 'wiro\modules\users\controllers\admin\SuspendAction',
	    'unsuspend' => 'wiro\modules\users\controllers\admin\UnsuspendAction',
	    'delete' => 'wiro\modules\users\controllers\admin\DeleteAction',
	);
    }
}