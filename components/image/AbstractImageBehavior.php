<?php

namespace wiro\components\image;

use CActiveRecordBehavior;
use CUploadedFile;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
abstract class AbstractImageBehavior extends CActiveRecordBehavior
{
    public $uploadPath = '';
    public $imageClass = 'wiro\components\image\Image';
    public $preserveFilename = false;
    public $removeOnDelete = true;
    public $removeOnUpdate = true;
    protected $originalValues = array();
    private $attributes = array();
    
    public function getAttributes()
    {
	return $this->attributes;
    }
    
    public function setAttributes($attributes)
    {
	if(!is_array($attributes)) {
	    preg_match_all('/\w+/', $attributes, $matches);
	    $attributes = $matches[0];
	}
	
	foreach($attributes as $attribute => $params) {
	    if(!is_array($params)) {
		$attribute = $params;
		$params = array();
	    }
	    $this->attributes[$attribute] = $params;
	}
    }
    
    public function afterFind($event)
    {
	foreach($this->attributes as $attribute => $params) {
	    if($this->owner->$attribute)
		$this->owner->$attribute = unserialize($this->owner->$attribute);
	    $this->originalValues[$attribute] = $this->owner->$attribute;
	}
    }
    
    public function afterValidate($event)
    {
	foreach($this->attributes as $attribute => $params) {
	    if($this->owner->hasErrors($attribute))
		$this->owner->$attribute = $this->originalValues[$attribute];
	}
    }
    
    public function beforeSave($event)
    {
	foreach($this->attributes as $attribute => $params) 
	    $this->owner->$attribute = serialize($this->owner->$attribute);
    }
    
    /**
     * 
     * @param CUploadedFile $file
     * @param string $attribute
     * @return Image
     */
    protected function createImage($file, $attribute)
    {
	$relativePath = $this->saveUploadedFile($file, $attribute);
	$imageClass = $this->getParam($attribute, 'imageClass');
	return new $imageClass($relativePath);
    }
    
    /**
     * 
     * @param CUploadedFile $image
     * @param string $attribute
     * @return string
     */
    protected function saveUploadedFile($image, $attribute)
    {
	$preserveFilename = $this->getParam($attribute, 'preserveFilename');
	$uploadPath = $this->getParam($attribute, 'uploadPath');
	return Yii::app()->upload->saveUploadedFile($image, $uploadPath, $preserveFilename);
    }
    
    protected function getParam($attribute, $param)
    {
	return isset($this->attributes[$attribute][$param])
	    ? $this->attributes[$attribute][$param]
	    : $this->$param;
    }
}
