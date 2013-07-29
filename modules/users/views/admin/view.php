<fieldset>
    <legend>User <i><?php echo $model->username; ?></i></legend>

    <div class="btn-group">
	<?php if (!$model->active): ?>
	    <?= TbHtml::linkButton('Activate', array(
		'color' => 'success',
		'url' => array('activate', 'id' => $model->userId),
		'icon' => 'icon-ok icon-white',
	    ));?>
	<?php endif; ?>
	<?= TbHtml::linkButton('Update', array(
	    'url' => array('update', 'id' => $model->userId),
	    'icon' => 'pencil',
	));?>
	<?php if ($model->suspended): ?>
	    <?= TbHtml::linkButton('Unsuspend', array(
		'color' => 'success',
		'url' => array('unsuspend', 'id' => $model->userId),
		'icon' => 'icon-ban-circle icon-white',
	    ));?>
	<?php endif; ?>
	<?php if ($model->active && !$model->suspended && !$model->isLocked): ?>
	    <?= TbHtml::linkButton('Suspend', array(
		'color' => 'warning',
		'url' => array('suspend', 'id' => $model->userId),
		'icon' => 'icon-ban-circle icon-white',
	    ));?>
	<?php endif; ?>
	<?php if (!$model->isLocked): ?>
	    <?= TbHtml::linkButton('Delete', array(
		'color' => 'danger',
		'confirm' => 'Are you sure you want to delete this user?',
		'submit' => array('delete', 'id' => $model->userId),
		'icon' => 'icon-remove icon-white',
	    ));?>	
	<?php endif; ?>
    </div>
    
    <?= TbHtml::linkButton('Users list', array(
	'url' => array('index'),
	'icon' => 'list',
    )); ?>
    
    <hr/>
    
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
	    'username',
	    'roleName',
	    'email:email',
	    'registrationDate:datetime',
	    'lastLogin:datetime',
	),
    ));
    ?>
    
    <?php if($model->hasProfile) { 
	$this->renderPartial('/profile/view', array('model' => $model->profile)); 
    } ?>

</fieldset>