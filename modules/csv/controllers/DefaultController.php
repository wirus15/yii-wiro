<?php

namespace wiro\modules\csv\controllers;

use CUploadedFile;
use wiro\base\Controller;
use wiro\modules\csv\components\CsvExporter;
use wiro\modules\csv\components\CsvImporter;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DefaultController extends Controller
{
    public $layout = '//layouts/admin';
    
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
		'roles' => array('developer'),
	    ),
	    array('deny',
		'users' => array('*'),
	    ),
	);
    }
    
    public function actionImport()
    {
	if($file=CUploadedFile::getInstanceByName('csv')) {
	    $importer = new CsvImporter();
	    $importer->import($file->tempName);
	}
	$this->render('import');
    }
    
    public function actionExport()
    {
	if(isset($_POST['tables'])) {
	    $exporter = new CsvExporter();
	    $exporter
		->setOutputFile(Yii::app()->name.'.zip')
		->setTables($_POST['tables'])
		->export();
	}
	$this->render('export', array(
	    'tables' => Yii::app()->db->schema->tableNames,
	));
    }
}