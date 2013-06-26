<?php

namespace wiro\components\image;

use CUploadedFile;
use OutOfBoundsException;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class MultipleImagesBehavior extends AbstractImageBehavior
{
    public function afterFind($event)
    {
	parent::afterFind($event);
	foreach($this->attributes as $attribute => $params) {
	    if(!is_array($this->originalValues[$attribute]))
		$this->originalValues[$attribute] = array();
	}
    }
    
    public function beforeValidate($event)
    {
	foreach($this->attributes as $attribute => $params) 
	    $this->owner->$attribute = Yii::app()->upload->getUploadedFiles($this->owner, $attribute);
    }
    
    public function beforeSave($event)
    {
        foreach($this->attributes as $attribute => $params) {
	    $images = array();
	    foreach($this->owner->$attribute as $file) {
		if($file instanceof CUploadedFile) 
		    $images[] = $this->createImage($file, $attribute);
	    }
	    
	    $this->owner->$attribute = isset($this->originalValues[$attribute])
		    ? array_merge($this->originalValues[$attribute], $images)
		    : $images;
        }
	parent::beforeSave($event);
    }
    
    public function afterDelete($event)
    {
	foreach($this->attributes as $attribute => $params) {
	    if($this->getParam($attribute, 'removeOnDelete')) {
		foreach($this->originalValues[$attribute] as $image) 
		    @ unlink($image->path);
	    }
	}
    }
    
    /**
     * 
     * @param string $attribute
     * @param array $order
     */
    public function sortImages($attribute, $order)
    {
	$sorted = array();
	foreach($order as $imagePath) {
	    $image = $this->findImage($attribute, $imagePath);
	    array_push($sorted, $image);
	}
	$this->originalValues[$attribute] = $sorted;
    }
    
    public function removeImage($attribute, $relativePath)
    {
	$filter = function($image) use ($relativePath) {
	    return $image->relativePath !== $relativePath;
	};
	$this->originalValues[$attribute] = array_filter($this->originalValues[$attribute], $filter);
    }
    
    /**
     * 
     * @param string $attribute
     * @param string $relativePath
     * @return Image
     * @throws OutOfBoundsException
     */
    private function findImage($attribute, $relativePath)
    {
	foreach($this->originalValues[$attribute] as $image) {
	    if($image->relativePath === $relativePath)
		return $image;
	}
	throw new OutOfBoundsException('Invalid image path');
    }
}
