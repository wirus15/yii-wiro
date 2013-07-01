<?php
/* @var $this ConfigValueController */
/* @var $model ConfigValue */
?>

<h1>Edit Config</h1>

<?= TbHtml::button(Yii::t('wiro', 'Create new'), array(
    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
    'id' => 'create-button',
)); ?>

<div class="form" id="create-form">
    <div id="config-form-box" style="display: none">
	<?php $this->renderPartial('create', array(
	    'model' => $newModel,
	)); ?>
    </div>
</div>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'config-grid',
    'ajaxUpdate' => false,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'type' => 'striped bordered condensed',
    'columns' => array(
	'key',
	array(
	    'class' => 'wiro\modules\config\components\ConfigValueColumn',
	    'name' => 'value',
	),
	array(
	    'class' => 'bootstrap.widgets.TbButtonColumn',
	    'template' => '{delete}',
	),
    ),
));
?>

<script>
$('#create-button, #close-button').click(function() {
    $('#create-button, #config-form-box').toggle();
});  
</script>
