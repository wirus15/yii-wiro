<?php 
/* @var $this ContactForm */
/* @var $model ContactFormModel */
?>

<?php if ($this->messageSent): ?>
    <?= TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('wiro', 'Your message has been sent. Thank you for contacting us.'), array('closeText'=>'')); ?>
<?php else: ?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'type' => TbHtml::FORM_LAYOUT_HORIZONTAL
    )); ?>

    <?= $form->hiddenField($model, 'token'); ?>
    
    <p class="note"><?= Yii::t('wiro', 'Fields with'); ?> <span class="required">*</span> <?= Yii::t('wiro', 'are required.'); ?></p>

    <fieldset>
	<?= $form->textFieldRow($model, 'name', array('class'=>'input-block-level')); ?>
	<?= $form->textFieldRow($model, 'email', array('class'=>'input-block-level')); ?>
	<?= $form->textFieldRow($model, 'subject', array('class'=>'input-block-level')); ?>
	<?= $form->textAreaRow($model, 'body', array('rows'=>6, 'class'=>'input-block-level')); ?>
    </fieldset>
    
    <div class="form-actions">
	<?= TbHtml::submitButton(Yii::t('wiro', 'Send'), array(
	    'color'=> TbHtml::BUTTON_COLOR_DANGER, 'size' => 'normal')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php endif; ?>
