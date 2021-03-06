<?php /* @var $this AuthController */ ?>

<?php $this->beginContent($this->module->defaultLayout); ?>

<div class="auth-module">

	<?php $this->widget('bootstrap.widgets.TbMenu', array(
		'type' => 'tabs',
		'items' => array(
			array(
				'label' => Yii::t('AuthModule.main', 'Assignments'),
				'url' => array('/user/auth/assignment/index'),
				'active' => $this instanceof AssignmentController,
			),
			array(
				'label' => $this->capitalize($this->getItemTypeText(CAuthItem::TYPE_ROLE, true)),
				'url' => array('/user/auth/role/index'),
				'active' => $this instanceof RoleController,
			),
			array(
				'label' => $this->capitalize($this->getItemTypeText(CAuthItem::TYPE_TASK, true)),
				'url' => array('/user/auth/task/index'),
				'active' => $this instanceof TaskController,
			),
			array(
				'label' => $this->capitalize($this->getItemTypeText(CAuthItem::TYPE_OPERATION, true)),
				'url' => array('/user/auth/operation/index'),
				'active' => $this instanceof OperationController,
			),
		),
	));?>

	<?php echo $content; ?>

</div>

<?php $this->endContent(); ?>