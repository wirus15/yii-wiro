<?php

$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
	'companyName',
	'firstName',
	'lastName',
	'phone',
	'address',
    ),
));
?>