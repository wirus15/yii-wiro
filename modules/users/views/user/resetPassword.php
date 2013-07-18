<fieldset>
    <legend>Reset password</legend>
    
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
    )); ?>

    <div class="well well-small">Please enter below your <strong>username</strong> or <strong>email address</strong>.</div>
    
    <?= $form->textFieldRow($model, 'username', array('class' => 'span5', 'maxlength' => 255)); ?>
    
    <div class="form-actions">
	<?= TbHtml::submitButton('Reset', array('color' => 'primary')); ?>
	<?= TbHtml::linkButton('Cancel', array('url' => Yii::app()->user->loginUrl)); ?>
    </div>

    <?php $this->endWidget(); ?>

</fieldset>