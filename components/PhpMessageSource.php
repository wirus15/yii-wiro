<?php

namespace wiro\components;

use CPhpMessageSource;
use Yii;

/**
 * Description of PhpMessageSource
 *
 * @author wirus
 */
class PhpMessageSource extends CPhpMessageSource
{
    public $sourcePaths = array();
    
    protected function getMessageFile($category, $language) 
    {
	if(isset($this->sourcePaths[$category])) {
	    return Yii::getPathOfAlias($this->sourcePaths[$category]).DIRECTORY_SEPARATOR.$language.DIRECTORY_SEPARATOR.$category.'.php';
	} else {
	    return parent::getMessageFile($category, $language);
	}
    }
}
