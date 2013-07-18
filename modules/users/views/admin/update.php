<fieldset>
    <legend>Update user <i><?php echo $model->username; ?></i></legend>
    
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
    )); ?>

    <p class="well well-small">Fields with <span class="required">*</span> are required.</p>

    <?= $form->textFieldRow($model, 'username', array('class' => 'span5', 'maxlength' => 255)); ?>
    <?= $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 255)); ?>
    <?= $form->dropDownListRow($model, 'role', TbHtml::listData(Yii::app()->authManager->roles, 'name', 'description'), array('class' => 'span5')); ?>
    <?= $form->dropDownListRow($model, 'active', array('No', 'Yes'), array('class' => 'span5')); ?>
    <?= $form->dropDownListRow($model, 'suspended', array('No', 'Yes'), array('class' => 'span5')); ?>
    
    <?php if($model->hasProfile)
	$this->renderPartial('/profile/form', array(
	    'model' => $model->profile,
	    'form' => $form,
	));
    ?>
    
    <div class="form-actions">
	<?= TbHtml::submitButton('Save', array('color' => 'primary')); ?>
	<?= TbHtml::linkButton('Cancel', array('url' => array('view', 'id'=>$model->userId))); ?>
    </div>

    <?php $this->endWidget(); ?>

</fieldset>