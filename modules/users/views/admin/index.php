<fieldset>
    <legend>Manage Users</legend>

    <?= TbHtml::linkButton('Create new user', array('url'=>array('create'), 'color'=>'primary', 'icon'=>'icon-plus white-icon')); ?>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'type' => 'striped bordered condensed',
    'template' => '<div class=\"pull-right\">{summary}</div>{items}{pager}',
    'columns' => array(
	'username',
	'email:email',
	array(
	    'name' => 'registrationDate',
	    'filter' => false,
	),
	array(
	    'class' => 'wiro\modules\users\widgets\RoleColumn'
	),
	array(
	    'class' => 'wiro\modules\users\widgets\UserStatusColumn',
	),
	array(
	    'class' => 'bootstrap.widgets.TbButtonColumn',
	    'buttons' => array(
		'delete' => array(
		    'visible' => '!$data->isLocked',
		),
	    ),
	),
    ),
));

?>

</fieldset>
