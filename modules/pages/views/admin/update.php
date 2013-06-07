<?php 
/* @var $this AdminController */
/* @var $model Page */
?>

<fieldset>
    <legend>Edytuj stronę: <?php echo CHtml::encode($model->pageTitle) ?></legend>
    
    <p>
    <?= TbHtml::buttonGroup(array(
	array('label' => 'Lista stron', 'url' => array('index'), 'icon' => TbHtml::ICON_LIST),
    )); ?>
    </p>
    
    <?php echo $this->renderPartial('_form',array('model' => $model)); ?>
</fieldset>