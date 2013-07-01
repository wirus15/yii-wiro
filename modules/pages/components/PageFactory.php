<?php

namespace wiro\modules\pages\components;

use CActiveRecord;
use CApplicationComponent;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class PageFactory extends CApplicationComponent
{
    public $pageClass = 'wiro\modules\pages\models\Page';
    
    public function create($scenario = 'insert')
    {
	$pageClass = $this->pageClass;
	return new $pageClass($scenario);
    }
    
    public function find($criteria)
    {
	return CActiveRecord::model($this->pageClass)->find($criteria);
    }
}
