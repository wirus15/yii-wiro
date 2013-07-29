<fieldset>
    <legend>Create new user</legend>
    
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
    )); ?>

    <p class="well well-small">Fields with <span class="required">*</span> are required.</p>

    <?= $form->textFieldRow($user, 'username', array('class' => 'span5', 'maxlength' => 255)); ?>
    <?= $form->textFieldRow($user, 'email', array('class' => 'span5', 'maxlength' => 255)); ?>
    
    <?php if($profile)
	$this->renderPartial('/profile/form', array(
	    'model' => $profile,
	    'form' => $form,
	));
    ?>
    
    <div class="form-actions">
	<?= TbHtml::submitButton('Create', array('color' => 'primary')); ?>
	<?= TbHtml::linkButton('Cancel', array('url' => array('index'))); ?>
    </div>

    <?php $this->endWidget(); ?>

</fieldset>