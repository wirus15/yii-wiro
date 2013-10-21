<?php $this->breadcrumbs = array(
    'Profile' => array('view'),
    'Change password',
); ?>

<fieldset>
    <legend>Change password</legend>

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'password-form',
	'enableAjaxValidation' => false,
    )); ?>

    <?php echo $form->passwordFieldRow($model, 'oldPassword', array('class' => 'span5', 'maxlength' => 255)); ?>
    <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span5', 'maxlength' => 255)); ?>
    <?php echo $form->passwordFieldRow($model, 'confirmPassword', array('class' => 'span5', 'maxlength' => 255)); ?>

    <div class="form-actions">
	<?= TbHtml::submitButton('Save', array('color' => 'primary')); ?>
	<?= TbHtml::linkButton('Cancel', array('url' => array('view'))); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
