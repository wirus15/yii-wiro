<fieldset>
    <legend>Update user <i><?php echo $model->username; ?></i></legend>
    
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
    )); ?>

    <p class="well well-small">Fields with <span class="required">*</span> are required.</p>

    <?= $form->textFieldRow($model, 'username', array('class' => 'span5', 'maxlength' => 255)); ?>
    <?= $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 255)); ?>
    
    <?php if($model->hasProfile)
	$this->renderPartial('/profile/form', array(
	    'model' => $model->profile,
	    'form' => $form,
	));
    ?>
    
    <div class="form-actions">
	<?= TbHtml::submitButton('Save', array('color' => 'primary')); ?>
	<?= TbHtml::linkButton('Cancel', array('url' => array('view'))); ?>
    </div>

    <?php $this->endWidget(); ?>

</fieldset>