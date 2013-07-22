<fieldset>
    <legend>Import from CSV</legend>
    
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'export-form',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>

    <?= TbHtml::fileField('csv'); ?>
    
    <div class="form-actions">
	<?= TbHtml::submitButton('Import', array('color' => 'primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

</fieldset>