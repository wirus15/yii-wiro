<div class="form-signin well">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
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

    <p><?= TbHtml::submitButton(Yii::t('wiro', 'Log in'), array('class' => 'input-block-level', 'color'=> TbHtml::BUTTON_COLOR_PRIMARY)); ?></p>
    <?php if($this->module->allowRegistration): ?>
	<p><?= TbHtml::linkButton(Yii::t('wiro', 'Register'), array('class' => 'input-block-level', 'url'=> array('/user/user/register'))); ?></p>
    <?php endif; ?>
<?php $this->endWidget(); ?>
    <small><?= CHtml::link('I forgot my password', array('/user/user/reset-password')); ?></small>
</div>
