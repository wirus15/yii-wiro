<?php
/* @var $model Page */
/* @var $this AdminController */
?>

<fieldset>
    <legend>Strony statyczne</legend>

    <p>
    <?= TbHtml::buttonGroup(array(
	array('label' => 'Dodaj', 'url' => array('create'), 'color'=>TbHtml::BUTTON_COLOR_PRIMARY, 'icon' => 'icon-plus icon-white'),
    )); ?>
    </p>
    
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'pages-grid',
	'type' => 'bordered striped condensed',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
	    array(
		'name' => 'pageTitle',
		'type' => 'html',
		'value' => 'CHtml::link(CHtml::encode($data->pageTitle), array("update", "id"=>$data->pageId));',
	    ),
	    'pageAlias',
	    array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template' => '{update} {delete}',
	    ),
	),
    ));
    ?>
</fieldset>
