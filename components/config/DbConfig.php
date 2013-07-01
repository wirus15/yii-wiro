<?php

namespace wiro\components\config;

use CConfiguration;
use IApplicationComponent;
use wiro\helpers\ArrayFormatConverter;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class DbConfig extends CConfiguration implements IApplicationComponent
{
    /**
     * @var string
     */
    public $tableName = '{{config}}';
    /**
     *
     * @var boolean
     */
    private $isInitialized = false;
    
    public function init()
    {
	$this->load();
	$this->setReadOnly(true);
	$this->configureApp();
	$this->isInitialized = true;
    }
    
    public function load()
    {
	foreach(DbConfigValue::model()->findAll() as $model) {
	    $value = $this->ensureType($model->value, $model->type);
	    $this->add($model->key, $value);
	}
	$this->setReadOnly(true);
    }
    
    private function configureApp()
    {
	$data = ArrayFormatConverter::toMultidimensional($this);
	Yii::app()->configure($data);
    }
    
    private function ensureType($value, $type)
    {
	switch($type) {
	    case DbConfigValue::BOOLEAN:
		return (bool)$value;
	    case DbConfigValue::INTEGER:
		return (int)$value;
	    case DbConfigValue::FLOAT:
		return (double)$value;
	    default:
		return $value;
	}
    }

    /**
     * 
     * @return boolean
     */
    public function getIsInitialized()
    {
	return $this->isInitialized;
    }
}
