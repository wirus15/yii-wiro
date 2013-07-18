<?php

namespace wiro\modules\users\widgets;

use CHtml;
use TbDataColumn;
use wiro\modules\users\models\User;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class RoleColumn extends TbDataColumn
{
    public $name = 'role';
    private $roles;
    
    public function init()
    {
	$this->roles = CHtml::listData(Yii::app()->authManager->roles, 'name', 'description');
	$this->filter = $this->roles;
	$this->header = Yii::t('wiro', 'Role');
	parent::init();
    }
    
    /**
     * 
     * @param integer $row
     * @param User $data
     */
    protected function renderDataCellContent($row, $data)
    {
	echo $this->roles[$data['role']];
    }
}
