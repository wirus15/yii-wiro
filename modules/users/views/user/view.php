<?php $this->breadcrumbs = array(
    'Profile',
); ?>

<fieldset>
    <legend>User <i><?php echo $model->username; ?></i></legend>

    <div class="btn-group">
	<?= TbHtml::linkButton('Update', array(
	    'url' => array('update'),
	    'icon' => 'pencil',
	));?>
	<?= TbHtml::linkButton('Change password', array(
	    'url' => array('password'),
	    'icon' => 'lock',
	));?>
    </div>
    
    <hr/>
    
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
	    'username',
	    'email:email',
	    'registrationDate:datetime',
	),
    ));
    ?>
    
    <?php if($model->hasProfile) { 
	$this->renderPartial('/profile/view', array('model' => $model->profile)); 
    } ?>

</fieldset>