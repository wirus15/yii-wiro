<?php

namespace wiro\components\sortable;

use CHtml;
use CWidget;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ReorderList extends CWidget
{
    public $models = array();
    
    public function run()
    {
	Yii::app()->clientScript
	    ->registerCoreScript('jquery.ui')
	    ->registerScript('sorting-list', '$("#'.$this->id.'").sortable();');
	
	echo CHtml::openTag('ul', array('class'=>'nav nav-tabs nav-stacked', 'id'=>$this->id));
	foreach($this->models as $model) {
	    echo CHtml::openTag('li');
	    echo CHtml::openTag('a', array('href'=>'#'));
	    echo CHtml::hiddenField('itemId[]', $model->primaryKey);
	    echo CHtml::encode($model);
	    echo CHtml::closeTag('a');
	    echo CHtml::closeTag('li');
	}
	echo CHtml::closeTag('ul');
    }
}