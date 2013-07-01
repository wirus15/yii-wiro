<?php

namespace wiro\modules\config\components;

use TbDataColumn;
use wiro\components\config\DbConfigValue;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ConfigValueColumn extends TbDataColumn
{
    public $mode = 'inline';
    public $url = array('update');
    
    protected function renderDataCellContent($row, $data)
    {
	switch($data->type) {
	    case DbConfigValue::BOOLEAN:
		$this->renderBooleanField($data);
		break;
	    case DbConfigValue::DATE:
		$this->renderDateField($data);
		break;
	    case DbConfigValue::DATETIME:
		$this->renderDatetimeField($data);
		break;
	    default:
		$this->renderTextField($data);
	}
    }
    
    private function renderBooleanField($data)
    {
	Yii::app()->controller->widget('bootstrap.widgets.TbEditableField', array(
	    'model' => $data,
	    'attribute' => $this->name,
	    'type' => 'select',
	    'url' => $this->url,
	    'mode' => $this->mode,
	    'source' => array(
		Yii::t('wiro', 'No'),
		Yii::t('wiro', 'Yes'),
	    ),
	));
    }
    
    private function renderTextField($data)
    {
	Yii::app()->controller->widget('bootstrap.widgets.TbEditableField', array(
	    'model' => $data,
	    'attribute' => $this->name,
	    'type' => 'text',
	    'url' => $this->url,
	    'mode' => $this->mode,
	));
    }
    
    private function renderDateField($data)
    {
	Yii::app()->controller->widget('bootstrap.widgets.TbEditableField', array(
	    'model' => $data,
	    'attribute' => $this->name,
	    'type' => 'date',
	    'url' => $this->url,
	    'mode' => $this->mode,
	));
    }
    
    private function renderDatetimeField($data)
    {
	Yii::app()->controller->widget('bootstrap.widgets.TbEditableField', array(
	    'model' => $data,
	    'attribute' => $this->name,
	    'type' => 'combodate',
	    'format' => 'YYYY-MM-DD HH:mm',
	    'template' => 'YYYY-MM-DD   HH:mm',
	    'url' => $this->url,
	    'mode' => $this->mode,
	));
    }
}
