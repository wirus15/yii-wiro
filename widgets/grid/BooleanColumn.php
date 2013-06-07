<?php

namespace wiro\widgets\grid;

use Yii;
use TbDataColumn;

Yii::import('bootstrap.widgets.TbDataColumn');

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class BooleanColumn extends TbDataColumn
{
    public $type = 'boolean';
    
    public function init()
    {
	parent::init();
	if(!$this->filter)
	    $this->filter = array(
		Yii::app()->format->boolean(false),
		Yii::app()->format->boolean(true),
	    );
    }
}
