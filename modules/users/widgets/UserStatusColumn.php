<?php

namespace wiro\modules\users\widgets;

use TbDataColumn;
use TbHtml;
use wiro\modules\users\models\User;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class UserStatusColumn extends TbDataColumn
{
    public $value = '';
    public $headerHtmlOptions = array('width'=>10);
    public $header = 'Status';
    /**
     * 
     * @param integer $row
     * @param User $data
     */
    protected function renderDataCellContent($row, $data)
    {
	if(!$data->active)
	    echo TbHtml::labelTb(Yii::t('wiro', 'Inactive'));
	elseif($data->suspended)
	    echo TbHtml::labelTb(Yii::t('wiro', 'Suspended'), array('color'=>TbHtml::LABEL_COLOR_IMPORTANT));
	else
	    echo TbHtml::labelTb(Yii::t('wiro', 'Active'), array('color'=>TbHtml::LABEL_COLOR_SUCCESS));
    }
}
