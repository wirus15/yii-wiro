<?php 
/* @var $this AdminController */
/* @var $model Page */
?>

<div class="form">
    
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

    <p class="note">Pola oznaczone <span class="required">*</span> są wymagane.</p>

    <div class="well" style="overflow: auto">
	<?= $form->textFieldRow($model, 'pageTitle', array('class' => 'input-block-level', 'maxlength' => 255)) ?>
	<?= $form->redactorRow($model, 'pageContent',array('rows'=>6)) ?>
	<?= $form->textFieldRow($model, 'pageAlias', array('class' => 'span5')); ?>
	<?= $form->textFieldRow($model, 'pageView', array('class' => 'span5')); ?>
    </div>
    
    <div class="well" id="meta-data-container">
	<?php $this->beginWidget('bootstrap.widgets.TbCollapse');?>
	    <a data-toggle="collapse" href="#meta-data">Meta dane</a>
	    
	    <div id="meta-data" class="collapse">
		<div style="margin-top: 20px">
		    <?= $form->textFieldRow($model, 'metaKeywords', array('class' => 'span5', 'maxlength' => 255)) ?>
		    <?= $form->textAreaRow($model,'metaDescription',array('rows'=>6, 'cols'=>50, 'class'=>'span8')) ?>
		</div>
	    </div>
	<?php $this->endWidget();?>
    </div>             
    
    <?= TbHtml::formActions(array(
	TbHtml::submitButton('Zapisz', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
	TbHtml::btn(TbHtml::BUTTON_TYPE_LINK ,'Anuluj', array('url' => array('index'))),
    )); ?>

    <?php $this->endWidget(); ?>
</div>