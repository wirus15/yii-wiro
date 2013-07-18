<fieldset>
    <legend>Register</legend>
    
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
    )); ?>

    <p class="well well-small">Fields with <span class="required">*</span> are required.</p>

    <?= $form->textFieldRow($user, 'username', array('class' => 'span5', 'maxlength' => 255)); ?>
    <?= $form->textFieldRow($user, 'email', array('class' => 'span5', 'maxlength' => 255)); ?>
    <?= $form->passwordFieldRow($user, 'password', array('class'=>'span5')); ?>
    <?= $form->passwordFieldRow($user, 'confirmPassword', array('class'=>'span5')); ?>
    
    <?php if($profile)
	$this->renderPartial('/profile/form', array(
	    'model' => $profile,
	    'form' => $form,
	));
    ?>
    
    <div class="form-actions">
	<?= TbHtml::submitButton('Register', array('color' => 'primary')); ?>
	<?= TbHtml::linkButton('Cancel', array('url' => Yii::app()->homeUrl)); ?>
    </div>

    <?php $this->endWidget(); ?>

</fieldset>