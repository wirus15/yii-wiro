<?php

use wiro\components\config\DbConfigValue;

$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'New config value',
    'headerIcon' => 'icon-cog',
));
?>

<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action' => array('create'),
	'type' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    ));
    ?>
	<fieldset>
	    <?= $form->dropDownListRow($model, 'type', array(
		DbConfigValue::STRING => 'String',
		DbConfigValue::INTEGER => 'Integer',
		DbConfigValue::FLOAT => 'Float',
		DbConfigValue::BOOLEAN => 'Boolean',
		DbConfigValue::DATE => 'Date',
		DbConfigValue::DATETIME => 'Date and time',
	    )); ?>
	    <?= $form->textFieldRow($model, 'key', array('class'=>'span8')); ?>
	    <?= $form->textFieldRow($model, 'value', array('class'=>'span8')); ?>
	</fieldset>
	
	<div class="controls">
	    <?= TbHtml::submitButton(Yii::t('wiro', 'Save'), array(
		'color' => TbHtml::BUTTON_COLOR_PRIMARY,
	    )); ?>

	    <?= TbHtml::button(Yii::t('wiro', 'Cancel'), array('id'=>'close-button')); ?>
	</div>
    <?php $this->endWidget(); ?>
</div>

<?php $this->endWidget(); ?>