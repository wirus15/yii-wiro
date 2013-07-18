<?php $this->emailSubject = Yii::app()->name.' - account registration'; ?>

<h2>Thank you for registering!</h2>

<p>Follow the link below to activate your account:</p>

<p><?= CHtml::link($link, $link); ?></p>