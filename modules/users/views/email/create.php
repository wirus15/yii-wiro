<?php $this->emailSubject = Yii::app()->name.' - account created'; ?>

<h2>Your account has been created.</h2>

<p>You may now log in using the following credentials:</p>

<p>username: <?= CHtml::link($link, $link); ?></p>