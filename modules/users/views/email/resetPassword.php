<?php $this->emailSubject = Yii::app()->name.' - reset password.'; ?>

<h2>New password</h2>

<p>Your password has been changed to this below:</p>

<p><strong><?= $password; ?></strong></p>

<p>You should change it as soon as possible. You can do it by following this link: </p>

<p><?= CHtml::link($link, $link); ?></p>
