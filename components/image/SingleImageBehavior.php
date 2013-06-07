<?php

namespace wiro\components\image;

use CUploadedFile;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class SingleImageBehavior extends AbstractImageBehavior
{  
    public function beforeValidate($event)
    {
	foreach($this->attributes as $attribute => $params) { 
	    $uploaded = Yii::app()->upload->getUploadedFile($this->owner, $attribute);
	    if($uploaded)
		$this->owner->$attribute = $uploaded;
	}
    }
    
    public function beforeSave($event)
    {
        foreach($this->attributes as $attribute => $params) {
	    $file = $this->owner->$attribute;
	    if($file instanceof CUploadedFile) {
		$this->owner->$attribute = $this->createImage($file, $attribute);
		if($this->getParam($attribute, 'removeOnUpdate'))
		    $this->removePrevious($attribute);
	    }
        }
	parent::beforeSave($event);
    }
        
    public function afterDelete($event)
    {
	foreach($this->attributes as $attribute => $params) {
	    if($params['removeOnDelete'])
		$this->removePrevious($attribute);
	}
    }
    
    /**
     * 
     * @param string $attribute
     */
    private function removePrevious($attribute)
    {
	$previous = $this->originalValues[$attribute];
	if($previous instanceof Image)
	    @unlink($previous->path);
    }
}
