<?php

namespace wiro\widgets\grid;

use CDataColumn;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class BooleanColumn extends CDataColumn 
{
    public $type = 'boolean';
    
    public function init()
    {
	parent::init();
	if(!$this->filter)
	    $this->fiter = array(
		Yii::t('wiro', 'No'),
		Yii::t('wiro', 'Yes'),
	    );
    }
}
