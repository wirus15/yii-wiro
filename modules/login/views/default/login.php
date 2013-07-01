<div class="form-signin well">
    <? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'type' => TbHtml::FORM_LAYOUT_VERTICAL,
    )); ?>

    <fieldset>
	<?= $form->textFieldRow($model, 'username', array(
	    'class' => 'input-block-level', 
	    'label' => false, 
	    'placeholder' => $model->getAttributeLabel('username'),
	)); ?>
	<?= $form->passwordFieldRow($model, 'password', array(
	    'class' => 'input-block-level',
	    'label' => false,
	    'placeholder' => $model->getAttributeLabel('password'),
	)); ?>
	
	<?php if (Yii::app()->user->allowAutoLogin)
	    echo $form->checkBoxRow($model, 'rememberMe'); ?>
    </fieldset>

    <?= TbHtml::submitButton(Yii::t('wiro', 'Log in'), array('class' => 'input-block-level', 'color'=> TbHtml::BUTTON_COLOR_PRIMARY)); ?>
<?php $this->endWidget(); ?>
</div>
