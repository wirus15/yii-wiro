<?php

namespace wiro\components;

use CFormatter;
use Yii;

/**
 * Description of Formatter
 *
 * @author wirus
 */
class Formatter extends CFormatter
{
    public function init()
    {
	parent::init();
	if($this->booleanFormat === array('No', 'Yes'))
	    $this->booleanFormat = array(Yii::t('wiro', 'No'), Yii::t('wiro', 'Yes'));
    }
}
