<?php
/*$this->menu = array(
    array('label' => 'CURRENT USER'),
    array('label' => 'Activate', 'url' => array('activate', 'id' => $model->userId), 'visible' => !$model->active, 'icon' => 'ok'),
    array('label' => 'Update', 'icon' => 'pencil', 'items' => array(
	array('label' => 'Account', 'url' => array('/user/admin/update', 'id' => $model->userId)),
	array('label' => 'Profile', 'url' => array('/user/admin/profile', 'id' => $model->userId)),
    )),
    array('label' => 'Roles', 'url' => array('roles', 'id' => $model->userId), 'icon' => 'tasks', 'linkOptions' => array('class' => 'open-modal', 'data-size' => 'small')),
    array('label' => 'Suspend', 'url' => array('suspend', 'id' => $model->userId), 'visible' => !$model->suspended, 'icon' => 'ban-circle'),
    array('label' => 'Unsuspend', 'url' => array('unsuspend', 'id' => $model->userId), 'visible' => $model->suspended, 'icon' => 'ok-sign'),
    array('label' => 'Delete', 'url' => array('delete', 'id' => $model->userId), 'linkOptions' => array('class' => 'delete-confirm', 'data-text' => 'Are you sure you want to delete this item?'), 'icon' => 'trash'),
    array('label' => 'USERS'),
    array('label' => 'Users list', 'url' => array('/user/admin/index'), 'icon' => 'user'),
    array('label' => 'OTHER'),
    array('label' => 'Notifications', 'icon' => 'envelope', 'items' => array(
	    array('label' => 'Email messages', 'url' => array('/user/config/notifications', 'type' => 'email')),
	    array('label' => 'Flash messages', 'url' => array('/user/config/notifications', 'type' => 'flash')),
    )),
    //array('label' => 'Config', 'url' => array('/user/config/settings'), 'icon' => 'cog'),
);*/

?>

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